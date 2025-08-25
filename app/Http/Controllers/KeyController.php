<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomKey;
use App\Models\Room;


class KeyController extends Controller
{
    public function index()
    {
        $keys = RoomKey::with('room')->paginate(20);
        return view('keys.index', compact('keys'));
    }


    public function regenerate(Room $room)
    {
        $key = $room->key;
        $key->update(['barcode' => 'RM-' . $room->number . '-' . strtoupper(uniqid())]);
        return back()->with('success', 'Barcode kunci diperbarui.');
    }
}
