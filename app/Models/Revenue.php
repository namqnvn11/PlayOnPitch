<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    protected $table = 'revenues';

    protected $fillable = [
        'boss_id',
        'total_revenue',
        'total_invoice'
    ];

    public function Boss()
    {
        return $this->belongsTo(Boss::class, 'boss_id');
    }

}
