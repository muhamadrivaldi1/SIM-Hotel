<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class CheckOutController extends Controller
{
    public function store(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        $room->update([
            'status' => 'Available'
        ]);

        return redirect()->route('rooms.index')->with('success', 'Check-Out berhasil, kamar tersedia kembali.');
    }
}
