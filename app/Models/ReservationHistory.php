<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationHistory extends Model
{
    protected $table = 'reservation_histories';
use HasFactory;
    protected $fillable = [
        'user_id',
        'reservation_id',
        'status'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
