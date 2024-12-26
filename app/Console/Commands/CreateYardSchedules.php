<?php

namespace App\Console\Commands;

use App\Models\PriceTimeSetting;
use App\Models\Yard;
use App\Models\YardSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CreateYardSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-yard-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy tất cả các sân không khóa và có giá mặc định > 0
        $yards = Yard::where('block', false)->where('defaultPrice', '>', 0)->get();

        // Tạo lịch cho từng sân
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
        Log::info('đã chạy khởi tạo Lịch thành công.');
    }

    private function getPriceInTime($priceTimeSettings,$time,$defaultPrice):float
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
}
