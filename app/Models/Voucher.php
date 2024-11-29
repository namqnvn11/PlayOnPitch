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
        'block'
    ];


    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function User_Voucher()
    {
        return $this->hasMany(User_voucher::class);
    }
    public  function  image(){
        return $this->hasOne(Image::class, 'voucher_id');
    }
}
