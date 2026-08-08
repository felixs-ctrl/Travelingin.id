<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_price',
        'is_special_offer',
        'travel_date',
        'image',
        'whatsapp_link',
        'type',
        'package_type',
        'quota',
        'loyalty_points',
        'whats_included',
        'gallery'
    ];

    protected $casts = [
        'whats_included' => 'array',
        'gallery' => 'array',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
