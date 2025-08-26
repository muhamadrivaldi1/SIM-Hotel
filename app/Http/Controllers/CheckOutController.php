<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class CheckOutController extends Controller
{
    public function store($id)
    {
        $room = Room::findOrFail($id);
        $room->status = 'Available'; // kembalikan jadi kosong
        $room->save();

        return redirect()->route('rooms.index')->with('success', 'Check Out berhasil, kamar sudah kosong kembali.');
    }
}
