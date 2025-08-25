<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shift;
use App\Models\RoomKey;

class ShiftController extends Controller
{
    // Daftar shift
    public function index()
    {
        $shifts = Shift::with('user')->latest()->get();
        return response()->json($shifts);
    }

    // Mulai shift baru
    public function store(Request $request)
    {
        $shift = Shift::create([
            'user_id' => auth()->id(),
            'start_time' => now(),
        ]);

        return response()->json(['message' => 'Shift dimulai', 'data' => $shift]);
    }

    // Selesai shift → wajib serahkan semua kunci
    public function update(Request $request, $id)
    {
        $shift = Shift::findOrFail($id);

        $keys = RoomKey::where('is_returned', false)->count();
        if ($keys > 0) {
            return response()->json(['error' => 'Masih ada kunci yang belum dikembalikan'], 400);
        }

        $shift->update([
            'end_time' => now(),
        ]);

        return response()->json(['message' => 'Shift diserahkan', 'data' => $shift]);
    }
}
