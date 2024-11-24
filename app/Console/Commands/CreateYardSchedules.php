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
        // Lấy tất cả các sân không khóa và có giá mặc định >= 100,000
        $yards = Yard::where('block', false)->where('defaultPrice', '>=', 100000)->get();

        // Tạo lịch cho từng sân
        foreach ($yards as $yard) {
            // Kiểm tra sân và xác định số ngày cần tạo lịch
            // Thời gian xa nhất của lịch đã tạo
            $maxDate = Carbon::now()->addDays(7);
            $lastedDate = $yard->YardSchedules->max('date');
            if ($lastedDate) {
                $lastedTimeCreateSchedule = Carbon::parse($lastedDate);
                $numberOfDateStart = 8 - round($lastedTimeCreateSchedule->diffInDays($maxDate));
            } else {
                $numberOfDateStart = 0;
            }
            // Tiến hành tạo sân cho từng ngày
            for ($i = $numberOfDateStart + 1; $i < 8; $i++) {
                $currentDate = Carbon::now()->addDay($i);
                $currentDayOfWeekNumber = Carbon::parse($currentDate)->format('N');

                if ($yard->Boss->is_open_all_day) {
                    $openTime = Carbon::createFromFormat('H:i', '00:00');
                    $closeTime = Carbon::createFromFormat('H:i', "23:59");
                } else {
                    $openTime = Carbon::createFromFormat('H:i:s', $yard->Boss->time_open);
                    $closeTime = Carbon::createFromFormat('H:i:s', $yard->Boss->time_close);
                }
                $currentTime = $openTime;
                $priceTimeSettings = PriceTimeSetting::where('yard_id', $yard->id)
                    ->where('day_of_week', $currentDayOfWeekNumber < 6 ? 'MonFri' : 'Weekend')
                    ->get();

                while ($currentTime->lt($closeTime)) {
                    $price = $this->getPriceInTime($priceTimeSettings, $currentTime) ?? $yard->defaultPrice/2;
                    YardSchedule::create([
                        'yard_id' => $yard->id,
                        'date' => $currentDate->format('Y-m-d'),
                        'time_slot' => $currentTime->format('H:i') . '-' . $currentTime->addMinutes(30)->format('H:i'),
                        'reservation_id' => '0',
                        'block' => false,
                        'status' => false,
                        'price_per_hour' => $price,
                    ]);
                }
            }
        }
        Log::info('đã chạy khởi tạo Lịch thành công.');
    }

    private function getPriceInTime($priceTimeSettings, $time): ?float
    {
        foreach ($priceTimeSettings as $schedule) {
            $startTime = Carbon::createFromFormat('H:i:s', $schedule['start_time']);
            $endTime = Carbon::createFromFormat('H:i:s', $schedule['end_time']);

            // thêm đều kiện cho các khoản thời gian qua ngày vd 22:00->05:00
            if ($startTime->gt($endTime)) {
                //start to 24:00
                if ($time->gte($startTime) && $time->lt(Carbon::createFromFormat('H:i','24:00' ))) {
                    return $schedule['price_per_hour']/2;
                }
                //00:00 đến end
                if ($time->gte(Carbon::createFromFormat('H:i','00:00' )) && $time->lt($endTime)) {
                    return $schedule['price_per_hour']/2;
                }
            }

            if ($time->gte($startTime) && $time->lt($endTime)) {
                return $schedule['price_per_hour']/2;
            }
        }
        return null;
    }
}
