<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $table = 'revenues';

    protected $fillable = [
        'reservation_id',
        'total_revenue',
        'total_invoice'
    ];

    public function Reservations()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

}
