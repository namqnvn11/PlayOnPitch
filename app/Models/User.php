<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'phone',
        'address',
        'district_id',
        'google_id',
        'booking_count',
        'score',
        'block',
        'email_verified_at'
    ];

    public function District()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function Province()
    {
        return $this->district->province();
    }

    public function User_Voucher()
    {
        return $this->hasMany(User_voucher::class);
    }

    public function Rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'user_id');
    }

    public function Contacts()
    {
        return $this->hasMany(Contact::class, 'user_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
