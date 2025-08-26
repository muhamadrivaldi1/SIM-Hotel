<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;


class CheckInController extends Controller
{
    public function index()
    {
        // tampilkan daftar kamar yang available
        $rooms = Room::where('status', 'available')->get();
        return view('checkin.index', compact('rooms'));
    }

    public function store(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update([
            'status' => 'occupied'
        ]);

        return redirect()->route('rooms.index')->with('success', 'Check-In berhasil, kamar sudah terisi.');
    }
}
