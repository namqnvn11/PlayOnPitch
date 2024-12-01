<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boss extends Authenticatable
{
    use HasFactory;

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
        'is_open_all_day'
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

}
