<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yard extends Model
{
    use HasFactory;
    protected $table = 'yards';

    protected $fillable = [
        'boss_id',
        'yard_name',
        'yard_type',
        'description',
        'block',
        'district_id',
        'defaultPrice'
    ];

    public function District()
    {
        return $this->belongsTo(district::class, 'district_id');
    }

    public function Boss()
    {
        return $this->belongsTo(Boss::class, 'boss_id');
    }
    public function PriceTimeSettings()
    {
        return $this->hasMany(PriceTimeSetting::class, 'yard_id');
    }
    public function YardSchedules(){
        return $this->hasMany(YardSchedule::class, 'yard_id');
    }
    public function image()
    {
        return $this->hasOne(Image::class, 'yard_id');
    }
}
