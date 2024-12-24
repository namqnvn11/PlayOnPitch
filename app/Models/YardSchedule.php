<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YardSchedule extends Model
{
    use HasFactory;
    protected $table = 'yard_schedules';

    protected $fillable = [
        'yard_id',
        'date',
        'price_per_hour',
        'time_slot',
        'status',
        'reservation_id',
        'block'
    ];

    public function Yard()
    {
        return $this->belongsTo(Yard::class, 'yard_id');
    }

    public function Reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
