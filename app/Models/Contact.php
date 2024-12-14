<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable=[
        'name',
        'phone',
        'user_id',
        'invoice_id',
    ];
    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function Invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
    public function Reservations(){
        return $this->hasMany(Reservation::class,'contact_id');
    }
}
