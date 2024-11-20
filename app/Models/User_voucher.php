<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_voucher extends Model
{
    use HasFactory;

    protected $table = 'user_vouchers';

    protected $fillable = [
        'user_id',
        'voucher_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}
