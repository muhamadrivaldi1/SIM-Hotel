<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryOrder extends Model
{
    protected $fillable = [
        'guest_id',
        'item',
        'weight',
        'price',
        'status'
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
