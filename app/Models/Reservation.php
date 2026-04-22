<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Reservation extends Model
{
    protected $fillable = [
        'field_id',
        'user_id',
        'start_time',
        'end_time',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public static function expirePendingReservations(): int
    {
        return static::query()
            ->where('status', 'pending')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', Carbon::now())
            ->update(['status' => 'cancelled']);
    }

    public function scopeActiveBlocking(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereIn('status', ['payed', 'confirmed'])
                ->orWhere(function (Builder $pending) {
                    $pending->where('status', 'pending')
                        ->whereNotNull('expires_at')
                        ->where('expires_at', '>', Carbon::now());
                });
        });
    }

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
