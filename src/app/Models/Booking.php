<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_CANCELLED = 'cancelled';

    public const TYPE_DAILY = 'daily';
    public const TYPE_HOURLY = 'hourly';

    protected $fillable = [
        'cabin_id',
        'booking_type',
        'guest_name',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'check_in_at',
        'check_out_at',
        'guests_count',
        'notes',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
    ];

    public function cabin(): BelongsTo
    {
        return $this->belongsTo(Cabin::class);
    }
}
