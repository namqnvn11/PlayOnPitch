<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $table = 'vouchers';

    protected $fillable = [
        'name',
        'price',
        'release_date',
        'end_date',
        'conditions_apply',
        'user_id',
        'block'
    ];


    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
