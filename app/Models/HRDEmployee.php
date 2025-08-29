<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRDEmployee extends Model
{
    use HasFactory;

    protected $table = 'h_r_d_employees'; // sesuaikan dengan tabel di database

    protected $fillable = [
        'name',
        'position',
        'salary',
        'status'
    ];
}
