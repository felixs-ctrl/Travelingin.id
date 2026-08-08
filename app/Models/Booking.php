<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'tanggal_booking',
        'jumlah_orang',
        'destination_id',
        'total_price',
        'dp_amount',
        'status',
        'payment_proof',
        'pelunasan_proof',
        'cancellation_reason',
        'points_earned'
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
