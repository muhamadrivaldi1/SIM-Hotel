<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = [
        'employee_id',
        'shift_date',
        'shift_time'
    ];

    public function employee()
    {
        return $this->belongsTo(HRDEmployee::class, 'employee_id');
    }
}
