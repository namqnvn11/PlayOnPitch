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
        $pricingData = PriceTimeSetting::where('yard_id', $id)->orderBy('start_time', 'asc')->get();
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

            // kết quả là vd:
//            [[
//                "from" => 1734631200
//                "to" => 1734638400
//                "price" => "400000"
//                "fromTime" => "01:00"
//                "toTime" => "03:00"
//                "timeSlotId" => "18"
//            ],[]...]

           //kiểm tra timeslot tối thiểu là 30'
            if (!$this->hasMinimumInterval($monFriSlots) || !$this->hasMinimumInterval($weekendSlots)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Each time slot must be at least 30 minutes.',
                ]);
            }
            //kiểm tra có kết thúc là 00||30
            if (!$this->hasValidMinutes($monFriSlots) || !$this->hasValidMinutes($weekendSlots)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Times must end with :00 or :30.',
                ]);
            }

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

            //kiểm tra có quá giới hạn thời gian mở cửa True/False
            $isOpenAllDay= Auth::guard('boss')->user()->is_open_all_day;
            if (!$isOpenAllDay) {
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
                'defaultPrice'=> str_replace(',', '', $request->input('defaultPrice'))
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


    //thời gian setup tối thiểu là 30'
    function hasMinimumInterval($timeSlots) {
        $minimumInterval = 30 * 60;
        foreach ($timeSlots as $timeSlot) {
            //bỏ qua nếu là có tg qua ngày
            if ($timeSlot['from'] > $timeSlot['to']) {
                continue;
            }
            if (($timeSlot['to'] - $timeSlot['from']) < $minimumInterval) {
                return false;
            }
        }
        return true;
    }

    // kiểm tra thời gian kết thúc phải là 30||00
    private function hasValidMinutes($timeSlots) {
        foreach ($timeSlots as $timeSlot) {
            $fromMinutes = date('i', $timeSlot['from']);
            $toMinutes = date('i', $timeSlot['to']);

            if (!in_array($fromMinutes, ['00', '30']) || !in_array($toMinutes, ['00', '30'])) {
                return false;
            }
        }
        return true;
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
                        'price'=> str_replace(',', '',$data["{$prefix}-price-{$index}"]) ?? null,
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
        $count=0;
        foreach ($timeSlots as $timeSlot) {
            if ($timeSlot['from'] > $timeSlot['to']) {
                $count++;

            }
        }
        if ($count==1){
            $isTimeOverDay=true;
        }elseif ($count>1){
            return false;
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
        return true;
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

    function setOpenTime(Request $request,$id)
    {
        if ($request->has('is_open_all_day')) {
            Boss::find($id)->update([
                'is_open_all_day'=> true,
                'time_open'=>null,
                'time_close'=>null,
            ]);

        }else{
            if ($request->time_close == '00:00') {
                // Xử lý trường hợp time_close là 00:00
                $validator = Validator::make($request->all(), [
                    'time_open' => ['required'],
                    'time_close' => ['required'],
                ]);
            } else {
                // Trường hợp time_close không phải là 00:00
                $validator = Validator::make($request->all(), [
                    'time_open' => ['required'],
                    'time_close' => ['required', 'after:time_open'],
                ]);
            }

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
                // kiểm tra có kết thúc là 00||30
                if (!$this->isValidTimeFormat(request('time_open'))||!$this->isValidTimeFormat(request('time_close'))) {
                    return response()->json([
                        'success' => false,
                        'message' => ['Time Times must end with :00 or :30.']
                    ]);
                }

                if (!$this->isDurationDivisibleBy1_5(request('time_open'),request('time_close'))) {
                    return response()->json([
                        'success' => false,
                        'message' => ['The opening time duration must be divisible by 1.5 hours.']
                    ]);
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

    private function isValidTimeFormat($time) {
        $parts = explode(':', $time);
        if (count($parts) !== 2) {
            return false;
        }
        $minutes = $parts[1];
        return in_array($minutes, ['00', '30']);
    }
    function isDurationDivisibleBy1_5($time_open, $time_close)
    {
        // Chuyển đổi thời gian mở và đóng thành đối tượng Carbon
        $open = Carbon::createFromFormat('H:i', $time_open);
        $close = Carbon::createFromFormat('H:i', $time_close);

        // Tính chênh lệch thời gian theo phút
        $durationInMinutes = $close->diffInMinutes($open);

        // Kiểm tra chia hết cho 90 phút (1.5 giờ = 90 phút)
        return $durationInMinutes % 90 === 0;
    }

    function isTimeWithinOperatingHours(array $timeSlots): array
    {
        // Lấy thông tin từ Auth guard
        $user = Auth::guard('boss')->user();
        $openTime = Carbon::parse($user->time_open); // Chuyển thành đối tượng Carbon
        $closeTime = Carbon::parse($user->time_close);
        $violations = [];
        // Nếu closeTime là 00:00:00, cộng thêm một ngày
        if ($closeTime->format('H:i:s') === '00:00:00') {
            $closeTime->addDay();
        }

        foreach ($timeSlots as $slot) {
            $fromTime = Carbon::parse($slot['fromTime']);
            $toTime = Carbon::parse($slot['toTime']);
            if ($toTime->format('H:i:s') === '00:00:00') {
                $toTime->addDay();
            }
            // Kiểm tra khoảng thời gian không hợp lệ (ví dụ: fromTime > toTime)
            if ($fromTime->greaterThan($toTime)) {
                $violations[] = [
                    'slot' => $slot,
                    'error' => 'Invalid time range: fromTime is later than toTime.'
                ];
                continue;
            }

            // Kiểm tra khoảng thời gian nằm ngoài thời gian hoạt động
            if ($fromTime->lessThan($openTime) || $toTime->greaterThan($closeTime)) {
                $violations[] = $slot; // Lưu các slot vi phạm vào mảng
            }
        }
        return $violations;
    }

    function scheduleCreate()
    {
        //lấy tất cả các sân không khóa và đã có giá mặc định >0
        $yards = Yard::where('block',false)->where('defaultPrice','>',0)->get();
        //tạo lịch cho từng sân
        foreach ($yards as $yard) {
            //kiểm tra sân và xác định số ngày cần tạo lịch
            $maxDate = Carbon::now()->addDays(7);
            $lastedDate = $yard->YardSchedules->max('date');

            if ($lastedDate) {
                $lastedTimeCreateSchedule = Carbon::parse($lastedDate);
                $numberOfDateStart = 8 - round($lastedTimeCreateSchedule->diffInDays($maxDate));
            } else {
                $numberOfDateStart = 0;
            }
            //tiến hành taọ sân cho từng ngày
            for ($i=$numberOfDateStart+1; $i <8 ; $i++){
                $currentDate = Carbon::now()->addDay($i);
                $currentDayOfWeekNumber = Carbon::parse($currentDate)->format('N');

                if ($yard->Boss->is_open_all_day) {
                    $openTime = Carbon::createFromFormat('H:i', '00:00');
                    $closeTime = Carbon::createFromFormat('H:i', '00:00')->addDay();
                } else {
                    $openTime = Carbon::createFromFormat('H:i:s', $yard->Boss->time_open);

                    $timeClose = $yard->Boss->time_close;
                    if ($timeClose =='00:00:00') {
                        $closeTime = Carbon::createFromFormat('H:i:s', $timeClose)->addDay();
                    }else{
                        $closeTime = Carbon::createFromFormat('H:i:s', $timeClose);
                    }
                }
                $currentTime = $openTime;
                $priceTimeSettings = PriceTimeSetting::
                where('yard_id', $yard->id)
                    ->where('day_of_week',$currentDayOfWeekNumber<6?'MonFri':'Weekend')
                    ->get();

                while ($currentTime->lt($closeTime)) {
                    // Tạo bản sao của $currentTime để truyền vào hàm getPriceInTime
                    $timeForCalculation = $currentTime->copy();

                    // Tính giá tiền dựa trên thời gian sao chép
                    $price = $this->getPriceInTime($priceTimeSettings, $timeForCalculation, $yard->defaultPrice);
                    // Tạo bản ghi lịch sân
                    YardSchedule::create([
                        'yard_id' => $yard->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'time_slot' => $currentTime->format('H:i') . '-' . $currentTime->copy()->addMinutes(90)->format('H:i'),
                        'reservation_id' => '0',
                        'block' => false,
                        'price_per_hour' => $price,
                    ]);

                    // Tăng thời gian $currentTime lên 90 phút
                    $currentTime->addMinutes(90);
                }

            }
        }
        return back()->with('success','Price Time Setting Schedule Created Successfully');
    }

    function getPriceInTime($priceTimeSettings,$time,$defaultPrice):float
    {
        $totalPrice = 0;
        $count=3;
        for ($i=1;$i<=3;$i++){
            foreach ($priceTimeSettings as $schedule) {
                //tính tiền trên các đoạn 30' của 1.5h rồi cộng lại
                $startTime = Carbon::createFromFormat('H:i:s', $schedule['start_time']);
                $endTime = Carbon::createFromFormat('H:i:s', $schedule['end_time']);

                // thêm đều kiện cho các khoản thời gian qua ngày vd 22:00->05:00
                if ($startTime->gt($endTime)) {
                    //start to 24:00
                    if ($time->gte($startTime) && $time->lt(Carbon::createFromFormat('H:i','24:00' ))) {
                        $totalPrice+= $schedule['price_per_hour']/2;
                        $count--;
                    }
                    //00:00 đến end
                    if ($time->gte(Carbon::createFromFormat('H:i','00:00' )) && $time->lt($endTime)) {
                        $totalPrice+= $schedule['price_per_hour']/2;
                        $count--;
                    }
                }
                elseif ($time->gte($startTime) && $time->lt($endTime)) {
                    $totalPrice+= $schedule['price_per_hour']/2;
                    $count--;
                }
            }
            //tăng 30' để tính
            $time->addMinutes(30);
        }
        $total=$totalPrice+($defaultPrice/2)*$count;
        return $total;
    }
    function scheduleDelete()
    {
        YardSchedule::all()->each(function ($schedule) {
            $schedule->delete();
        });
        return back()->with('success','Price Time Setting Schedule Deleted Successfully');
    }


    function createAllYardSchedule(){
        $boss=Auth::guard('boss')->user();
        $yardIdList=$boss->Yards->pluck('id')->toArray();
        foreach ($yardIdList as $yardId) {
            $this->scheduleCreate($yardId);
        }
        return response()->json([
            'success'=>true,
            'message'=>'All Yard Schedule Created Successfully'
        ]);
    }
    function deleteAllYardSchedule(){
        $boss=Auth::guard('boss')->user();
        $yardIdList = $boss->Yards()->where('block',0)->pluck('id')->toArray();
        foreach ($yardIdList as $yardId) {
            $this->deleteSchedule($yardId);
        }
        return response()->json([
            'success'=>true,
            'message'=>'All Yard Schedule Deleted Successfully'
        ]);
    }
    function createOneYardSchedule($yardId){
        $this->createSchedule($yardId);
        return response()->json([
            'success' => true,
            'message' => 'Yard with ID ' . $yardId . ' schedule created successfully'
        ]);

    }
    function deleteOneYardSchedule($yardId){
        $this->deleteSchedule($yardId);
        return response()->json([
            'success' => true,
            'message' => 'Yard Schedule Deleted Successfully'
        ]);
    }

    private function deleteSchedule($yardId)
    {
        $lastBookedDate = YardSchedule::where('yard_id', $yardId)
            ->where('status', '<>', 'available')
            ->orderBy('date', 'desc')
            ->value('date');
        $lastBookedDate=$lastBookedDate? Carbon::parse($lastBookedDate)->format('Y-m-d'): Carbon::now()->format('Y-m-d');
        $lastBookedDate = Carbon::parse($lastBookedDate);
        YardSchedule::where('yard_id', $yardId)
            ->where('date', '>', $lastBookedDate)
            ->delete();
    }

    //hàm tạo lịch của 1 sân
    private function createSchedule($yardId){
        $yard=Yard::find($yardId);
        //kiểm tra sân và xác định số ngày cần tạo lịch
        $maxDate = Carbon::now()->addDays(7);
        $lastedDate = $yard->YardSchedules->max('date');

        if ($lastedDate) {
            $lastedTimeCreateSchedule = Carbon::parse($lastedDate);
            $numberOfDateStart = 8 - round($lastedTimeCreateSchedule->diffInDays($maxDate));
        } else {
            $numberOfDateStart = 0;
        }
        //tiến hành taọ sân cho từng ngày
        for ($i=$numberOfDateStart+1; $i <8 ; $i++){
            $currentDate = Carbon::now()->addDay($i);
            $currentDayOfWeekNumber = Carbon::parse($currentDate)->format('N');

            if ($yard->Boss->is_open_all_day) {
                $openTime = Carbon::createFromFormat('H:i', '00:00');
                $closeTime = Carbon::createFromFormat('H:i', '00:00')->addDay();
            } else {
                $openTime = Carbon::createFromFormat('H:i:s', $yard->Boss->time_open);

                $timeClose = $yard->Boss->time_close;
                if ($timeClose =='00:00:00') {
                    $closeTime = Carbon::createFromFormat('H:i:s', $timeClose)->addDay();
                }else{
                    $closeTime = Carbon::createFromFormat('H:i:s', $timeClose);
                }

            }
            $currentTime = $openTime;
            $priceTimeSettings = PriceTimeSetting::
            where('yard_id', $yard->id)
                ->where('day_of_week',$currentDayOfWeekNumber<6?'MonFri':'Weekend')
                ->get();
            while ($currentTime->lt($closeTime)) {
                // Tạo bản sao của $currentTime để truyền vào hàm getPriceInTime
                $timeForCalculation = $currentTime->copy();

                // Tính giá tiền dựa trên thời gian sao chép
                $price = $this->getPriceInTime($priceTimeSettings, $timeForCalculation, $yard->defaultPrice);
                // Tạo bản ghi lịch sân
                YardSchedule::create([
                    'yard_id' => $yard->id,
                    'date' => $currentDate->format('Y-m-d'),
                    'time_slot' => $currentTime->format('H:i') . '-' . $currentTime->copy()->addMinutes(90)->format('H:i'),
                    'reservation_id' => '0',
                    'block' => false,
                    'price_per_hour' => $price,
                ]);

                // Tăng thời gian $currentTime lên 90 phút
                $currentTime->addMinutes(90);
                Log::info($currentTime->format('Y-m-d H:i:s'));
            }

        }

    }
}


