<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'payment_id',
        'qr_code_hash',
        'scan_status'
    ];

    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
