<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Owner;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        Owner::create([
            'username' => 'owner1',
            'password' => Hash::make('password123'), // password terenkripsi
        ]);
    }
}
