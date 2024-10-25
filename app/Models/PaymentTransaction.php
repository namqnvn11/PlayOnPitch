<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $table = 'payment_transactions';

    protected $fillable = [
        'user_id',
        'invoice_id',
        'transaction_id',
        'amount',
        'status',
        'request_id',
        'payment_method',
        'response_data'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
