<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Field;

class Price extends Model
{
    protected $fillable = [
        'field_id',
        'day_of_week',
        'price',
    ];

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }
}