<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = [
        'name',
        'province_id',
    ];

    public function Province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function Boss()
    {
        return $this->hasMany(Boss::class);
    }

    public function User()
    {
        return $this->hasMany(Boss::class);
    }
}
