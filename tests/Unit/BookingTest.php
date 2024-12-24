<?php

namespace Tests\Unit;

use App\Jobs\ExpireReservationJob;
use App\Models\Contact;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\User;
use App\Models\YardSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /** @test */
    public function it_can_create_a_reservation_successfully()
    {
        Queue::fake();

        // Tạo dữ liệu giả cho YardSchedule
        $yardSchedules = YardSchedule::factory()->count(2)->create(['status' => 'available']);
        $data = [
            'scheduleIds' => $yardSchedules->pluck('id')->toArray(),
            'userName' => 'John Doe',
            'user_id' => null,
            'boss_id' => 1,
            'phone' => '123456789',
            'total_price' => 500000,
        ];

        // Tạo người dùng giả và đăng nhập
        $user = User::factory()->create();  // Tạo người dùng giả
        $this->actingAs($user);  // Đăng nhập người dùng giả

        // Gửi yêu cầu POST
        $response = $this->post(route('user.choice_yard.makeReservation'), $data);

        // Kiểm tra phản hồi chuyển hướng đúng
        $response->assertRedirect(route('user.payment.index', [
            'yard_schedule_ids' => $data['scheduleIds'],
            'reservation_id' => Reservation::first(),
            'total_price' => $data['total_price'],
            'contact_id' => Contact::first(),
            'boss_id' => $data['boss_id'],
        ]));

        // Kiểm tra dữ liệu đã được lưu vào database
        $this->assertDatabaseHas('contacts', [
            'name' => $data['userName'],
            'phone' => $data['phone'],
        ]);

        $this->assertDatabaseHas('reservations', [
            'total_price' => $data['total_price'],
            'payment_status' => 'pending',
            'reservation_status' => 'paying',
        ]);

        $this->assertDatabaseHas('reservation_histories', [
            'status' => 'paying',
        ]);

        foreach ($yardSchedules as $schedule) {
            $this->assertDatabaseHas('yard_schedules', [
                'id' => $schedule->id,
                'status' => 'pending',
            ]);
        }

        // Kiểm tra cookie
        $cookie = Cookie::get('reservation');

        // Kiểm tra job đã được dispatch
        Queue::assertPushed(ExpireReservationJob::class, 2);
    }

    /** @test */
    public function it_fails_when_a_schedule_is_not_available()
    {
        $yardSchedules = YardSchedule::factory()->count(2)->create(['status' => 'booked']);
        $data = [
            'scheduleIds' => $yardSchedules->pluck('id')->toArray(),
            'userName' => 'John Doe',
            'user_id' => null,
            'boss_id' => 1,
            'phone' => '123456789',
            'total_price' => 500000,
        ];

        $response = $this->post(route('user.choice_yard.makeReservation'), $data);

        $this->assertDatabaseCount('reservations', 0);
        $this->assertDatabaseCount('yard_schedules', 2);
    }
}
