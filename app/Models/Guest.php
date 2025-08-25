<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    // Nama tabel jika bukan 'guests' bisa diubah
    protected $table = 'guests';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status' // misal: 'Checked In', 'Checked Out'
    ];
}
