<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    // Tampilkan daftar check-in
    public function index()
    {
        $checkins = Checkin::with(['guest', 'room'])->get();
        return response()->json($checkins);
    }

    // Form check-in baru
    public function create()
    {
        $guests = Guest::all();
        $rooms  = Room::where('status', 'available')->get();

        return response()->json([
            'guests' => $guests,
            'rooms'  => $rooms
        ]);
    }

    // Simpan check-in baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'room_id'  => 'required|exists:rooms,id',
            'checkin_date' => 'required|date',
            'checkout_date' => 'nullable|date|after:checkin_date'
        ]);

        $checkin = Checkin::create($validated);

        // update status room jadi occupied
        Room::where('id', $validated['room_id'])->update(['status' => 'occupied']);

        return response()->json(['message' => 'Check-in berhasil', 'data' => $checkin]);
    }

    public function checkoutIndex()
    {
        // Semua check-in yang belum check-out
        $checkins = Checkin::with(['guest', 'room'])
            ->whereNull('checkout_date')
            ->get();

        return view('admin.checkouts.index', compact('checkins'));
    }


    // Detail check-in
    public function show($id)
    {
        $checkin = Checkin::with(['guest', 'room'])->findOrFail($id);
        return response()->json($checkin);
    }

    // Proses check-out
    public function checkout($id)
    {
        $checkin = Checkin::findOrFail($id);
        $checkin->update(['checkout_date' => now()]);

        // Update status room jadi available
        $checkin->room->update(['status' => 'available']);

        return response()->json(['message' => 'Check-out berhasil', 'data' => $checkin]);
    }

    // Hapus check-in
    public function destroy($id)
    {
        $checkin = Checkin::findOrFail($id);
        $checkin->delete();

        return response()->json(['message' => 'Data check-in berhasil dihapus']);
    }
}
