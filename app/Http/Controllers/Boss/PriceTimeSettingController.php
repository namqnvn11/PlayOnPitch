<?php

namespace App\Http\Controllers\Boss;

use App\Http\Controllers\Controller;
use App\Models\Boss;
use App\Models\PriceTimeSetting;
use App\Models\Yard;
use App\Models\YardSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use function Pest\Laravel\delete;

class PriceTimeSettingController extends Controller
{


    //id là id của sân
    function getPricing($id)
    {
        // Lấy tất cả các bản ghi liên quan đến yard_id
        $pricingData = PriceTimeSetting::where('yard_id', $id)->get();
        $defaultPrice= Yard::find($id)->defaultPrice;

        // Kiểm tra nếu có dữ liệu liên quan đến yard_id
        $isTimeSet = $pricingData->isNotEmpty();

        // Lọc các bản ghi cho MonFri và Weekend
        $monFri = $pricingData->where('day_of_week', 'MonFri')->values();
        $weekend = $pricingData->where('day_of_week', 'Weekend')->values();

        return response()->json([
            'success' => true,
            'MonFri' => $monFri,
            'Weekend' => $weekend,
            'isTimeSet' => $isTimeSet,
            'defaultPrice'=>$defaultPrice,
        ]);
    }

    //id của yard
    function pricing(Request $request,$id)
    {
        $validator= Validator::make($request->all(),[
            'defaultPrice'=> 'required',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ],422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }


        try {
            $data= $request->all();
            //chia thời gian mon-fri và weekend
            $monFriSlots = $this->extractTimeSlots($data, 'mon-fri');
            $weekendSlots = $this->extractTimeSlots($data, 'weekend');
            //kiểm tra price có hợp lệ

            if(!$this->validatePrice($monFriSlots)||!$this->validatePrice($weekendSlots)){
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a valid price'
                ]);
            }

            //sort theo thứ tự xét theo from time
            $this->sortTimeSlotsByFromTime($monFriSlots);
            $this->sortTimeSlotsByFromTime($weekendSlots);

            //kiểm tra có quá giới hạn thời gian mở cửa
            $isOpenAllDay= Auth::guard('boss')->user()->is_open_all_day;
            if (!$isOpenAllDay) {
                // Giả sử bạn có hai mảng monFriSlots và weekendSlots
                $violationsMonFri = $this->isTimeWithinOperatingHours($monFriSlots);
                $violationsWeekend = $this->isTimeWithinOperatingHours($weekendSlots);
                if (!empty($violationsMonFri) || !empty($violationsWeekend)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'There is an overlap on the opening time, please check again!'
                    ]);
                }

            }

            //kiểm tra thời gian cung cấp có bị trùng lập với nhau
            if (!$this->validateTimeSlots($monFriSlots)){
                return response()->json([
                    'success' => false,
                    'message'=> 'There is an overlap in Monday to friday time, please check again !!!'
                ]);
            }
            if(!$this->validateTimeSlots($weekendSlots)){
                return response()->json([
                    'success' => false,
                    'message'=> 'There is an overlap in weekend times, please check again !!!'
                ]);
            }



            // lưu dữ liệu vào data base
            // bảng price
            $currentTimeSlotIdArray=[];
            if (!empty($monFriSlots)) {
                foreach ($monFriSlots as $monFriSlot) {
                    $timeSlotId=$monFriSlot['timeSlotId'];
                    if ($timeSlotId!==null){
                       $check= PriceTimeSetting::find($timeSlotId)->update([
                            'start_time'=> $monFriSlot['fromTime'],
                            'end_time'=> $monFriSlot['toTime'],
                            'price_per_hour'=> $monFriSlot['price'],
                        ]);
                        $currentTimeSlotIdArray[]=$timeSlotId;
                    }else{
                        $check=PriceTimeSetting::create([
                            'yard_id'=> $id,
                            'day_of_week'=> 'MonFri',
                            'start_time'=> $monFriSlot['fromTime'],
                            'end_time'=> $monFriSlot['toTime'],
                            'price_per_hour'=> $monFriSlot['price'],
                        ]);
                        $currentTimeSlotIdArray[]=$check->id;
                    }
                }
            }
            if (!empty($weekendSlots)) {
                foreach ($weekendSlots as $weekendSlot) {
                    $timeSlotId=$weekendSlot['timeSlotId'];
                    if ($timeSlotId!==null){
                        $check=PriceTimeSetting::find($timeSlotId)->update([
                            'start_time'=> $weekendSlot['fromTime'],
                            'end_time'=> $weekendSlot['toTime'],
                            'price_per_hour'=> $weekendSlot['price'],
                        ]);
                        $currentTimeSlotIdArray[]=$timeSlotId;
                    }else{
                       $check= PriceTimeSetting::create([
                            'yard_id'=> $id,
                            'day_of_week'=> 'Weekend',
                            'start_time'=> $weekendSlot['fromTime'],
                            'end_time'=> $weekendSlot['toTime'],
                            'price_per_hour'=> $weekendSlot['price'],
                        ]);
                       $currentTimeSlotIdArray[]=$check->id;
                    }
                }
            }

            //xóa các thời gian cũ

            //lấy danh sách các id time slot id cũ đối chiếu với các id mới để xóa
            $ids = PriceTimeSetting::where('yard_id',$id)->pluck('id')->toArray();
            // Tìm các id có trong $ids nhưng kông có trong $currentTimeSlotIdArray
            $idsToDelete = array_diff($ids, $currentTimeSlotIdArray);
            // Xóa các id này khỏi bảng
            PriceTimeSetting::whereIn('id', $idsToDelete)->delete();


            //lưu giá mặc điịnh
            Yard::find($id)->update([
                'defaultPrice'=> $request['defaultPrice'],
            ]);

            return response()->json([
                'success' => true,
                'message'=> 'Price Time Setting Updated Successfully',
            ]);

        }catch (\Exception $e){
            Log::error('Error updating price settings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],400);
        }

    }

    function sortTimeSlotsByFromTime(&$timeSlots)
    {
        usort($timeSlots, function ($a, $b) {
            return $a['from'] <=> $b['from'];
        });
    }

    //hàm tách tg montofri và weekend
    function extractTimeSlots($data, $prefix)
    {
        $timeSlots = [];

        foreach ($data as $key => $value) {

            if (strpos($key, "{$prefix}-from-time") !== false) {

                $index = str_replace("{$prefix}-from-time-", '', $key);
                $from = $value;
                $to = $data["{$prefix}-to-time-{$index}"] ?? null;
                // Lấy giá trị của timeSlotId hoặc gán null nếu không tồn tại
                $timeSlotId = $data["{$prefix}-time-slot-id-{$index}"] ?? null;

                if ($from && $to) {
                    // Chuyển đổi thời gian thành timestamp
                    $fromTime = strtotime($from);
                    $toTime = strtotime($to);

                    $timeSlots[] = [
                        'from' => $fromTime,
                        'to' => $toTime,
                        'price'=> $data["{$prefix}-price-{$index}"] ?? null,
                        'fromTime' => $from,
                        'toTime' => $to,
                        'timeSlotId' => $timeSlotId,
                    ];
                }
            }
        }
        return $timeSlots;
    }

    //hàm kiểm tra thời gian trùng lập
    function validateTimeSlots($timeSlots)
    {
        if (count($timeSlots) === 1) {
            if ($timeSlots[0]['from']===$timeSlots[0]['to']){
                return false;
            }
            return true;
        }
        //kiểm tra có tg qua ngày
        $isTimeOverDay=false;
        foreach ($timeSlots as $timeSlot) {
            if ($timeSlot['from'] > $timeSlot['to']) {
                $isTimeOverDay=true;
            }
        }
        for ($i = 0; $i < count($timeSlots); $i++) {
            $j=$i+1;
            //chỉ xảy ra khi không có thời gian qua đêm
            if ($j==count($timeSlots)) {
                if ($isTimeOverDay) {
                    $j = 0;
                }else{
                    return true;
                }
            }
            $slotA = $timeSlots[$i];
            $slotB = $timeSlots[$j];
            if ($slotA['to'] > $slotB['from'] || $slotA['from'] == $slotA['to']) {
                return false;
            }
        }
        return true; // Không có trùng lặp
    }

    function validatePrice($timeSlots) {
        // Kiểm tra nếu mảng timeSlots có phần tử null
        foreach ($timeSlots as $slot) {
            if (is_null($slot)) {
                return false;// Trả về lỗi ngay khi tìm thấy null
            }
        }

        // Kiểm tra nếu giá trị price không phải là số
        foreach ($timeSlots as $slot) {
            if ( !is_numeric($slot['price']) || $slot['price']==null) {
               return false;// Trả về lỗi nếu price không hợp lệ
            }
        }

        return true; // Trả về true nếu không có lỗi
    }

// Hàm thông báo lỗi


    function setOpenTime(Request $request,$id)
    {
        if ($request->has('is_open_all_day')) {
            Boss::find($id)->update([
                'is_open_all_day'=> true,
                'time_open'=>null,
                'time_close'=>null,
            ]);

        }else{
            $validator = Validator::make($request->all(), [
                'time_open' => ['required'],
                'time_close' => ['required', 'after:time_open']
        ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ],422);
            }
            try {
                $currentBoss= Boss::find($id);

                //nếu như chuyển từ mở cả ngày sang khoảng tg thì reset lại time setting
                if ($currentBoss->is_open_all_day==true) {
                    $yards = $currentBoss->Yards; // Lấy tất cả các 'Yard' của 'currentBoss'
                    foreach ($yards as $yard) {
                        $yard->PriceTimeSettings()->delete();
                    }
                }
                $currentBoss->update([
                    'time_open'=>request('time_open'),
                    'time_close'=>request('time_close'),
                    'is_open_all_day'=>false,
                ]);
            }catch (\Exception $e){
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
        return response()->json([
            'success' => true,
            'message'=> 'Price Time Setting Updated Successfully',
        ]);

    }

    function isTimeWithinOperatingHours(array $timeSlots): array
    {
        // Lấy thông tin từ Auth guard
        $user = Auth::guard('boss')->user();
        $openTime = $user->time_open;
        $closeTime = $user->time_close;

        // Chuyển đổi thời gian mở và đóng sang timestamp để so sánh dễ dàng
        $openTimestamp = strtotime($openTime);
        $closeTimestamp = strtotime($closeTime);

        $violations = [];

        foreach ($timeSlots as $slot) {
            $fromTimestamp = strtotime($slot['fromTime']);
            $toTimestamp = strtotime($slot['toTime']);

            // Kiểm tra xem khoảng thời gian có nằm ngoài thời gian hoạt động không
            if ($fromTimestamp < $openTimestamp || $toTimestamp > $closeTimestamp) {
                $violations[] = $slot; // Lưu các slot vi phạm vào mảng
            }
        }

        return $violations;
    }

    function test()
    {
        //lấy tất cả các sân
        $yards = Yard::where('block',false)->get();

        //thời gian xa nhất của lịch đã tạo
        $lastedTimeCreateSchedule = Carbon::parse( YardSchedule::max('date'));

        //sẽ tạo lịch cách 7 ngày so với hiện tại
        $numberOfDayToCreateSchedule=round($lastedTimeCreateSchedule->diffInDays(Carbon::now()->addDay(7)));
        dd($numberOfDayToCreateSchedule);
        for ($i=$numberOfDayToCreateSchedule; $i <8 ; $i++) {
            $date = Carbon::now()->addDay($i);
            $currentDayOfWeekNumber = Carbon::parse($date)->format('N');
            foreach ($yards as $yard) {
                if ($yard->Boss->is_open_all_day) {
                    $openTime = Carbon::createFromFormat('H:i','00:00' );
                    $closeTime = Carbon::createFromFormat('H:i', "23:59");
                } else {
                    $openTime = Carbon::createFromFormat('H:i:s', $yard->Boss->time_open);
                    $closeTime = Carbon::createFromFormat('H:i:s', $yard->Boss->time_close);
                }
                $currentTime = $openTime;
                $priceTimeSettings = PriceTimeSetting::
                where('yard_id', $yard->id)
                    ->where('day_of_week',$currentDayOfWeekNumber<6?'MonFri':'Weekend')
                    ->get();
                while ($currentTime->lt($closeTime)) {
                    $price= $this->getPriceInTime($priceTimeSettings,$currentTime)??$yard->defaultPrice;
                    YardSchedule::create([
                        'yard_id' => $yard->id,
                        'date' => $date->format('Y-m-d'),
                        'time_slot' => $currentTime->format('H:i') . '-' . $currentTime->addMinutes(30)->format('H:i'),
                        'reservation_id' => '0',
                        'block' => false,
                        'status' => false,
                        'price_per_hour' => $price,
                    ]);
                }
            }
        }

        return view('boss.yard.test');
    }

    function getPriceInTime($priceTimeSettings,$time):?float
    {
        foreach ($priceTimeSettings as $schedule) {
            $startTime = Carbon::createFromFormat('H:i:s', $schedule['start_time']);
            $endTime = Carbon::createFromFormat('H:i:s', $schedule['end_time']);

            if ($time->gte($startTime) && $time->lt($endTime)) {
                return $schedule['price_per_hour'];
            }
        }
        return null;
    }
    function delete()
    {
        YardSchedule::all()->each(function ($schedule) {
            $schedule->delete();
        });
        return view('boss.yard.test');
    }
}


