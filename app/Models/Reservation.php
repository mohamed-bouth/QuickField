<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'field_id',
        'user_id',
        'start_time',
        'end_time',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function field(){
        return $this->belongsTo(Field::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
