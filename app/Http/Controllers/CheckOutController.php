<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    /**
     * Proses check-out kamar
     */
    public function store(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $room = Room::findOrFail($id);

            // Pastikan kamar sedang Occupied
            if ($room->status !== 'Occupied') {
                return back()->with('error', 'Check-Out gagal, kamar tidak sedang dihuni.');
            }

            // Validasi catatan checkout (opsional)
            $request->validate([
                'note' => 'nullable|string|max:255',
            ]);

            // Update status kamar menjadi Cleaning setelah check-out
            $room->update([
                'status' => 'Cleaning',
                'last_checkout_at' => now(), // pastikan kolom ini ada
            ]);

            DB::commit();

            return back()->with('success', "Check-Out berhasil: Kamar {$room->number} sekarang status Cleaning.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat proses check-out: ' . $e->getMessage());
        }
    }
}
