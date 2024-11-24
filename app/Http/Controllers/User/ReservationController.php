<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\YardSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                        'reservation_status' => 0,
                        'code' => uniqid(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            // Insert tất cả các bản ghi vào cơ sở dữ liệu
            Reservation::insert($reservations);

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
        $selectedFields = $request->input('selectedFields'); // Danh sách sân và giờ người dùng chọn
        $selectedDate = $request->input('selectedDate');     // Ngày người dùng chọn

        $unavailableFields = [];

        foreach ($selectedFields as $field) {
            $schedule = YardSchedule::where('yard_id', $field['yardId'])
                ->where('time_slot', $field['time'])
                ->where('date', $selectedDate)
                ->first();

            if (!$schedule || $schedule->status === 'booked') {
                $unavailableFields[] = $field;
            }
        }

        if (count($unavailableFields) > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Một số sân hoặc giờ đã được đặt.',
                'unavailableFields' => $unavailableFields
            ]);
        }

        // Đặt chỗ cho tất cả các lựa chọn hợp lệ
        foreach ($selectedFields as $field) {
            YardSchedule::where('yard_id', $field['yardId'])
                ->where('time_slot', $field['time'])
                ->where('date', $selectedDate)
                ->update(['status' => 'booked', 'reservation_id' => auth()->id()]);
        }

        return response()->json(['success' => true, 'message' => 'Đặt sân thành công!']);
    }
}
