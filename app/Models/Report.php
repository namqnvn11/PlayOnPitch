<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'raiting_id',
        'user_id',
        'comment',
        'status'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Raiting()
    {
        return $this->belongsTo(Raiting::class, 'raiting_id');
    }
}
