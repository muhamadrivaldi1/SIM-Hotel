<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'guest_id',
        'room_id',
        'checkin_date',
        'checkout_date',
        'status',
    ];

    // Casting tipe data
    protected $casts = [
        'checkin_date'  => 'datetime',
        'checkout_date' => 'datetime',
    ];

    /**
     * Relasi ke Guest
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /**
     * Relasi ke Room
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Scope untuk checkin yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}
