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
        'deposit_amount',
        'payment_status',
        'reservation_status',
        'total_price',
        'code',
        'payment_type',
        'contact_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function YardSchedules(){
        return $this->hasMany(YardSchedule::class, 'reservation_id');
    }

    public function Revenues(){
        return $this->hasMany(Revenue::class, 'reservation_id');
    }

    public function Invoice(){
        return $this->hasOne(Invoice::class);
    }
    public function ReservationHistory(){
        return $this->hasOne(ReservationHistory::class, 'reservation_id');
    }

    function Contact(){
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
