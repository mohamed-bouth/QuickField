<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'field_id',
        'comment',
        'rating'
    ];

    public function field(){
        return $this->belongsTo(Field::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
