<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRDEmployee extends Model
{
    protected $fillable = [
        'name',
        'position',
        'salary',
        'status'
    ];

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'employee_id');
    }
}
