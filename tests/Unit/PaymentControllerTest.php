<?php

namespace Tests\Unit;

use App\Models\Boss;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\PaymentTransaction;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\User;
use App\Models\User_voucher;
use App\Models\YardSchedule;
use App\Services\MomoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cookie;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $momoServiceMock;

    public function setUp(): void
    {
        parent::setUp();

        // Mock MoMo service
        $this->momoServiceMock = \Mockery::mock(MomoService::class);
        $this->app->instance(MomoService::class, $this->momoServiceMock);
    }

    /** @test */
    public function it_displays_payment_page()
    {
        $boss = Boss::factory()->create();
        $contact = Contact::factory()->create();
        $yardSchedules = YardSchedule::factory()->count(3)->create([]);

        Cookie::queue(Cookie::forever('reservation', json_encode([
            'reservationId' => 1,
            'bossId' => $boss->id,
            'contactId' => $contact->id,
        ])));

        $response = $this->get(route('user.payment.index', [
            'boss_id' => $boss->id,
            'contact_id' => $contact->id,
            'yard_schedule_ids' => $yardSchedules->pluck('id')->toArray(),
            'total_price' => 100,
            'reservation_id' => 1,
        ]));

        $response->assertStatus(302);
    }

    /** @test */
    public function it_creates_full_payment_with_momo()
    {
        // Tạo dữ liệu cho người dùng
        $user = User::factory()->create();

        // Tạo đơn đặt chỗ (Reservation) cho người dùng vừa tạo
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'total_price' => 100000,
            'payment_status' => 'pending',
        ]);

        // Giả lập phản hồi MoMo (mocking)
        $momoResponse = [
            'resultCode' => 0,
            'payUrl' => 'https://test-payment.momo.vn/v2/gateway/api/create',
            'orderId' => uniqid(), // Mã đơn hàng tạo từ MoMo
        ];

        // Gửi yêu cầu POST để tạo thanh toán
        $response = $this->post('/momo/payment', [
            'reservation_id' => $reservation->id,
            'total_price' => 100000,
            'payment_type' => '1',
            'user_voucher' => 0,
        ]);

        // Lưu Invoice sau khi nhận được phản hồi từ MoMo
        $invoice = Invoice::create([
            'reservation_id' => $reservation->id,
            'invoice_date' => now(),
            'total_price' => 100000,
            'payment_method' => 'momo',
            'status' => 'pending',
        ]);

        // Lưu PaymentTransaction với thông tin từ MoMo
        PaymentTransaction::create([
            'transaction_id' => $momoResponse['orderId'], // Sử dụng orderId từ MoMo
            'invoice_id' => $invoice->id,
            'product_name' => 'Yard reservation payment',
            'amount' => 100000,
            'status' => 'Pending',
            'payment_method' => 'MoMo',
            'request_id' => 'non',
            'response_data' => 'non',
        ]);

        $this->assertDatabaseHas('invoices', [
            'reservation_id' => $reservation->id,
            'invoice_date' => $invoice->invoice_date->toDateString(),
            'total_price' => 100000,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('payment_transactions', [
            'transaction_id' => $momoResponse['orderId'],
            'invoice_id' => $invoice->id,
            'amount' => 100000,
            'status' => 'Pending',
            'payment_method' => 'MoMo',
        ]);
    }

    /** @test */
    public function it_handle_momo_payment_callback_success()
    {
        // Tạo dữ liệu mẫu
        $reservation = Reservation::factory()->create(['payment_status' => 'pending']);
        $invoice = Invoice::factory()->create(['reservation_id' => $reservation->id, 'status' => 'pending']);
        $payment = PaymentTransaction::factory()->create(['transaction_id' => '12345', 'invoice_id' => $invoice->id, 'status' => 'Pending']);
        $reservationHistory = ReservationHistory::factory()->create(['reservation_id' => $reservation->id, 'status' => 'pending']);
        $voucher = User_voucher::factory()->create(['voucher_id' => 1]);

        // Kiểm tra dữ liệu đã được tạo thành công
        $this->assertDatabaseHas('reservations', ['id' => $reservation->id]);
        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);
        $this->assertDatabaseHas('payment_transactions', ['transaction_id' => '12345']);
        $this->assertDatabaseHas('reservation_histories', ['reservation_id' => $reservation->id]);
        $this->assertDatabaseHas('user_vouchers', ['id' => $voucher->id]);

        // Giả lập callback từ MoMo (thành công)
        $response = $this->get('/momo/payment/callback', [
            'orderId' => '12345',
            'resultCode' => '0', // Thành công
        ]);

        // Kiểm tra cập nhật trạng thái của các bảng liên quan
        $this->assertDatabaseHas('payment_transactions');
        $this->assertDatabaseHas('invoices');
        $this->assertDatabaseHas('reservations');
        $this->assertDatabaseHas('reservation_histories');
    }

    /** @test */
    public function it_handle_momo_payment_callback_fail()
    {
        // Tạo dữ liệu mẫu
        $reservation = Reservation::factory()->create(['payment_status' => 'pending']);
        $invoice = Invoice::factory()->create(['reservation_id' => $reservation->id, 'status' => 'pending']);
        $payment = PaymentTransaction::factory()->create(['transaction_id' => '12345', 'invoice_id' => $invoice->id, 'status' => 'Pending']);
        $reservationHistory = ReservationHistory::factory()->create(['reservation_id' => $reservation->id, 'status' => 'pending']);

        // Giả lập callback từ MoMo (thất bại)
        $response = $this->post('/momo/callback', [
            'orderId' => '12345',
            'resultCode' => '1',
        ]);

        // Kiểm tra cập nhật trạng thái của các bảng liên quan
        $this->assertDatabaseHas('payment_transactions');
        $this->assertDatabaseHas('invoices');
        $this->assertDatabaseHas('reservations');
        $this->assertDatabaseHas('reservation_histories');
    }
}
