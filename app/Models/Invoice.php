<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'reservation_id',
        'invoice_date',
        'total_price',
        'payment_method',
        'status'
    ];

    public function Reservation()
    {
        return $this->hasOne(Reservation::class);
    }
}
