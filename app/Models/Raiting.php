<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raiting extends Model
{
    protected $table = 'raitings';

    protected $fillable = [
        'user_id',
        'yard_id',
        'point',
        'comment',
        'block'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Yard()
    {
        return $this->belongsTo(Yard::class, 'yard_id');
    }
}
