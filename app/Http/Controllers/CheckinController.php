<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    // Menampilkan daftar kamar yang tersedia untuk check-in
    public function index()
    {
        $rooms = Room::where('status', 'Available')->get();
        return view('checkin.index', compact('rooms'));
    }

    // Proses check-in manual via tombol atau form
    public function store(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        if ($room->status !== 'Available') {
            return redirect()->back()->with('error', 'Kamar ini tidak tersedia untuk check-in.');
        }

        // Update status kamar menjadi Occupied
        $room->update([
            'status' => 'Occupied'
        ]);

        return redirect()->route('checkin.index')->with('success', "Check-In berhasil: Kamar {$room->number} sudah terisi.");
    }

    // Proses check-in via barcode
    public function checkInBarcode(Request $request)
    {
        $barcode = $request->input('barcode');

        // Cari kamar berdasarkan barcode_key
        $room = Room::where('barcode_key', $barcode)->first();

        if (!$room) {
            return redirect()->back()->with('error', 'Kode barcode tidak ditemukan.');
        }

        if ($room->status !== 'Available') {
            return redirect()->back()->with('error', 'Kamar ini tidak tersedia untuk check-in.');
        }

        // Update status kamar menjadi Occupied
        $room->update(['status' => 'Occupied']);

        return redirect()->back()->with('success', "Check-In berhasil: Kamar {$room->number}");
    }
}
