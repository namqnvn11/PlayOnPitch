<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
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
        return $this->belongsTo(Reservation::class,'reservation_id');
    }

    public function Contact(){
        return $this->hasOne(Contact::class, 'id');
    }
}
