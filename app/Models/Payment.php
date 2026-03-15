<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reservation_id',
        'total_amount',
        'paid_amount',
        'status'
    ];

    public function reservation(){
        return $this->hasOne(Reservation::class);
    }

    public function ticket(){
        return $this->hasOne(Ticket::class);
    }
}
