<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $table = 'payment_transactions';

    protected $fillable = [
        'invoice_id',
        'transaction_id',
        'amount',
        'status',
        'request_id',
        'payment_method',
        'response_data'
    ];

    public function Invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
