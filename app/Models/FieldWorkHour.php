<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldWorkHour extends Model
{
    protected $fillable = [
        'field_id',
        'day_of_week',
        'open_time',
        'close_time',
    ];

    public function field (){
        return $this->belongsTo(Field::class);
    }
}
