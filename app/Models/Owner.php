<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Owner extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['username', 'password'];
    protected $hidden = ['password', 'remember_token'];
}
