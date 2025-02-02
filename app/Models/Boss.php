<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Boss extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'bosses';

    protected $fillable = [
        'email',
        'password',
        'full_name',
        'phone',
        'company_name',
        'company_address',
        'status',
        'district_id',
        'block',
        'time_open',
        'time_close',
        'is_open_all_day',
        'description'
    ];

    public function District()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function Province()
    {
        return $this->district->province();
    }
    public function Yards(){
        return $this->hasMany(Yard::class, 'boss_id');
    }

    public function images(){
        return $this->hasMany(Image::class, 'boss_id');
    }

    public function ratings(){
        return $this->hasMany(Rating::class, 'boss_id');
    }

}
