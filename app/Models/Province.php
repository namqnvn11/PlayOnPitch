<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    protected $fillable = [
        'name'
    ];

    public function Districts()
    {
        return $this->hasMany(District::class);
    }
}
