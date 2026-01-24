<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cabin extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_path',
        'location',
        'capacity',
        'max_extra_guests',
        'price_per_night',
        'price_per_hour',
        'extra_guest_price_per_night',
        'extra_guest_price_per_hour',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_per_night' => 'decimal:2',
        'price_per_hour' => 'decimal:2',
        'extra_guest_price_per_night' => 'decimal:2',
        'extra_guest_price_per_hour' => 'decimal:2',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
