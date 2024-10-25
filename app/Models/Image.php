<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'img',
        'user_id',
        'boss_id',
        'yard_id',
        'voucher_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Yard()
    {
        return $this->belongsTo(Yard::class, 'yard_id');
    }

    public function Boss()
    {
        return $this->belongsTo(Boss::class, 'boss_id');
    }

    public function Voucher()
    {
        return $this->belongsTo(Voucher::class, 'voucher_id');
    }
}
