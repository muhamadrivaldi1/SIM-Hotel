<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckinSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['number' => '145', 'type' => 'MASTER', 'status' => 'Occupied'],
            ['number' => '15889', 'type' => 'VIP', 'status' => 'Cleaning'],
            ['number' => '114', 'type' => 'MASTER', 'status' => 'Occupied'],
            ['number' => '234', 'type' => 'VIP', 'status' => 'Occupied'],
        ];

        foreach ($rooms as $room) {
            DB::table('rooms')->insert([
                'name'        => 'Room ' . $room['number'],
                'number'      => $room['number'],
                'type'        => $room['type'],
                'status'      => $room['status'],
                'barcode_key' => 'RM-' . $room['number'] . '-' . strtoupper(uniqid()),
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ]);
        }
    }
}
