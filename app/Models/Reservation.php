<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'yard_id',
        'reservation_date',
        'reservation_time_slot',
        'deposit_amount',
        'payment_status',
        'reservation_status',
        'total_price',
        'code',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Yard()
    {
        return $this->belongsTo(Yard::class, 'yard_id');
    }
}
