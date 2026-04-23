<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerAccountRequest extends Model
{
    protected $fillable = [
        'request_code',
        'name',
        'email',
        'phone',
        'password',
        'status',
        'user_id',
        'reviewed_by',
        'rejection_reason',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
