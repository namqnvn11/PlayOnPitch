<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';

    protected $fillable = [
        'rating_id',
        'user_id',
        'comment',
        'status'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Rating()
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }
}
