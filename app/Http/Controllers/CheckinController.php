<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckInController extends Controller
{
    // Tampilkan daftar kamar tersedia + form scan
    public function index()
    {
        $rooms = Room::where('status', 'Available')->get();
        return view('checkin.index', compact('rooms'));
    }

    // Check-in manual via tombol
    public function store(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        if ($room->status !== 'Available') {
            return redirect()->back()->with('error', "Kamar {$room->number} tidak tersedia untuk check-in.");
        }

        $room->update(['status' => 'Occupied']);

        return redirect()->route('checkin.index')->with('success', "Check-In berhasil: Kamar {$room->number}");
    }

    // Check-in via barcode
    public function checkInBarcode(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ], [
            'barcode.required' => 'Kode barcode harus diisi.'
        ]);

        $room = Room::where('barcode_key', $request->barcode)->first();

        if (!$room) {
            return redirect()->back()->with('error', 'Kode barcode tidak ditemukan.');
        }

        if ($room->status !== 'Available') {
            return redirect()->back()->with('error', "Kamar {$room->number} tidak tersedia untuk check-in.");
        }

        // Update database
        $room->update(['status' => 'Occupied']);

        return redirect()->back()->with('success', "Check-In berhasil via barcode: Kamar {$room->number}");
    }
}
