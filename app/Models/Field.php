<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'image_path',
        'localisation',
        'type',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function prices(){
        return $this->hasMany(Price::class);
    }

}
