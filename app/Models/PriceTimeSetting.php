<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceTimeSetting extends Model
{
    protected $table = 'price_time_settings';

    protected $fillable = [
        'yard_id',
        'day_of_week',
        'start_time',
        'end_time',
        'price_per_hour'
    ];

    public function Yard()
    {
        return $this->belongsTo(Yard::class, 'yard_id');
    }
}
