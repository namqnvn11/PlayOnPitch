<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\YardSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReservationHistory;

class ReservationController extends Controller
{
    public function storeReservation(Request $request)
    {
        try {
            // Validate dữ liệu đầu vào
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'yard_id' => 'required|array',
                'yard_id.*' => 'exists:yards,id', // Kiểm tra tất cả các giá trị trong mảng yard_id
                'reservation_date' => 'required|date',
                'reservation_time_slot' => 'required|array',
                'reservation_time_slot.*' => 'string',
                'total_price' => 'required|numeric',
            ]);

            $reservations = [];

            // Lặp qua tất cả sân đã chọn
            foreach ($validatedData['yard_id'] as $yardId) {
                // Lặp qua tất cả giờ đã chọn
                foreach ($validatedData['reservation_time_slot'] as $timeSlot) {
                    // Tạo mỗi kết hợp giữa sân và giờ
                    $reservations[] = [
                        'user_id' => $validatedData['user_id'],
                        'yard_id' => $yardId,
                        'reservation_date' => $validatedData['reservation_date'],
                        'reservation_time_slot' => $timeSlot,
                        'total_price' => $validatedData['total_price'],
                        'deposit_amount' => 0,
                        'payment_status' => 0,
                        'reservation_status' => 1,
                        'code' => uniqid(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert tất cả các bản ghi vào cơ sở dữ liệu
            Reservation::insert($reservations);

            // Lưu vào bảng reservation_histories để ghi nhận lịch sử đặt sân
            foreach ($reservations as $reservation) {
                ReservationHistory::create([
                    'user_id' => $reservation['user_id'],
                    'reservation_id' => $reservation['yard_id'],  // Sử dụng ID của đơn đặt sân
                    'status' => 'success', // Trạng thái là thành công
                ]);
            }


            // Chuyển hướng đến trang hóa đơn sau khi lưu
            flash()->success('Reservation created successfully');
            return redirect()->route('user.invoice.index', ['id' => $validatedData['yard_id'][0]]);
        } catch (\Exception $e) {
            flash()->error($e->getMessage());
            return redirect()->back();
        }
    }

    public function calculatePrice(Request $request)
    {
        $date = $request->input('selected_date');
        $fields = $request->input('fields'); // Danh sách sân và giờ
        $totalPrice = 0;
        $unavailableFields = [];
        foreach ($fields as $field) {
            $yardName = $field['yard'];
            $timeSlot = $field['time'];
            $yardSchedule = YardSchedule::whereHas('Yard', function ($query) use ($yardName) {
                $query->where('yard_name', $yardName);
            })
                ->where('date', $date)
                ->where('time_slot', $timeSlot)
                ->first();
            if ($yardSchedule && $yardSchedule->status === '0') {
                $unavailableFields[] = $field;
            } else {
                $totalPrice += $yardSchedule->price_per_hour;
            }
        }
        if (count($unavailableFields) > 0) {
            return response()->json([
                'totalPrice' => null,
                'unavailableFields' => $unavailableFields
            ]);
        }
        return response()->json(['totalPrice' => $totalPrice]);
    }

    public function checkAvailability(Request $request)
    {
        $selectedFields = $request->input('selectedFields');
        $selectedDate = $request->input('selectedDate');

        $unavailableFields = [];
        $availableFields = [];
        $currentTime = Carbon::now();

        foreach ($selectedFields as $field) {
            $schedule = YardSchedule::where('yard_id', $field['yardId'])
                ->where('time_slot', $field['time'])
                ->where('date', $selectedDate)
                ->first();

            $timeSlotDateTime = Carbon::createFromFormat('Y-m-d H:i', $selectedDate . ' ' . $field['time']);

            // Nếu sân đã đặt hoặc đã qua thời gian hiện tại
            if (!$schedule || $schedule->status === 'booked' || $timeSlotDateTime < $currentTime) {
                $unavailableFields[] = $field;
            } else {
                $availableFields[] = $field;
            }
        }

        if (count($unavailableFields) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Một số sân hoặc giờ không khả dụng.',
                'unavailableFields' => $unavailableFields,
                'availableFields' => $availableFields
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Tất cả các sân khả dụng!']);
    }
}
