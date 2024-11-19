<?php

namespace App\Console\Commands;

use App\Models\PriceTimeSetting;
use App\Models\Yard;
use App\Models\YardSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

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

//        //lấy tất cả các sân
//        $yards = Yard::all();
//
//        foreach ($yards as $yard) {
//            $priceTimeSettings = PriceTimeSetting::where('yard_id', $yard->id)->get();
//            if ( $yard->Boss->is_open_all_day){
//                $openTime=  Carbon::createFromFormat('H:i', "00:00");
//                $closeTime=  Carbon::createFromFormat('H:i', "23:59");
//            }else{
//                $openTime= Carbon::createFromFormat('H:i', $yard->Boss->time_open);
//                $closeTime= Carbon::createFromFormat('H:i', $yard->Boss->time_close);
//            }
//            $currentTime=$openTime;
//            $date = Carbon::now()->addDay(1)->toDateString();
//            while ($currentTime->lte($closeTime)) {
//                YardSchedule::create([
//                    'yard_id' => $yard->id,
//                    'date' => $date,
//                    'end_time' => $closeTime->toTimeString(),
//                    'time_slot'=> $currentTime->toTimeString() .'-'. $currentTime->addMinutes(30)->toTimeString(),
//                    'reservation_id'=>'0',
//                    'block'=>false,
//                    'status'=> false,
//                ]);
//            }
//
//
//        'price_per_hour',
//
//
//        }
//
//        $this->info('Yard schedules created successfully.');
    }
}
