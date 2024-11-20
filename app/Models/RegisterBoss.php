<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterBoss extends Model
{
    protected $table = 'register_bosses';

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];
}
