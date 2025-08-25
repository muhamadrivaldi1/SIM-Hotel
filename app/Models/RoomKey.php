<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomKey extends Model
{
    protected $fillable = [
        'room_id',
        'key_code',
        'status'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
