<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantOrder extends Model
{
    protected $fillable = [
        'guest_id',
        'menu',
        'quantity',
        'total_price',
        'status'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
