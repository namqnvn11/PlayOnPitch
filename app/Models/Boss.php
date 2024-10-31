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
        'block'
    ];

    public function District()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function Province()
    {
        return $this->district->province();
    }
}
