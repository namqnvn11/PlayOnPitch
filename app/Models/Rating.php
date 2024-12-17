<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'user_id',
        'boss_id',
        'point',
        'comment',
        'block'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Boss(){
        return $this->belongsTo(Boss::class, 'boss_id');
    }
}
