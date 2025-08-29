<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Checkin;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Front Office - tampilkan kamar dengan pagination
     */
    public function index()
    {
        $rooms = Room::orderBy('number')->paginate(8);
        return view('admin.dashboard', compact('rooms'));
    }

    /**
     * Admin - tampilkan semua kamar
     */
    public function adminIndex()
    {
        $rooms = Room::orderBy('number')->get();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Tampilkan form tambah kamar
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Simpan kamar baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:rooms,number',
            'type'   => 'required|string',
            'status' => 'required|string',
        ]);

        $status = ucfirst(strtolower(trim($request->status)));
        $validStatus = ['Available', 'Occupied', 'Cleaning', 'Locked'];

        if (!in_array($status, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid!');
        }

        $name    = 'Room ' . $request->number;
        $barcode = 'RM-' . $request->number . '-' . strtoupper(uniqid());

        Room::create([
            'name'        => $name,
            'number'      => $request->number,
            'type'        => $request->type,
            'status'      => $status,
            'barcode_key' => $barcode,
        ]);

        return redirect()->route('rooms.adminIndex')->with('success', 'Kamar berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail kamar
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.detail', compact('room'));
    }

    /**
     * Tampilkan form edit kamar
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update kamar
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $request->validate([
            'number' => 'required|unique:rooms,number,' . $room->id,
            'type'   => 'required|string',
            'status' => 'required|string',
        ]);

        $status = ucfirst(strtolower(trim($request->status)));
        $validStatus = ['Available', 'Occupied', 'Cleaning', 'Locked'];

        if (!in_array($status, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid!');
        }

        $room->update([
            'name'   => 'Room ' . $request->number,
            'number' => $request->number,
            'type'   => $request->type,
            'status' => $status,
        ]);

        return redirect()->route('rooms.adminIndex')->with('success', 'Kamar berhasil diperbarui!');
    }

    /**
     * Kunci kamar menggunakan barcode
     */
    public function lockWithBarcode(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        if ($request->barcode === $room->barcode_key) {
            $room->status = 'Locked';
            $room->save();
            return redirect()->back()->with('success', 'Kamar berhasil dikunci!');
        } else {
            return redirect()->back()->with('error', 'Barcode salah! Kunci kamar gagal.');
        }
    }

    /**
     * Hapus kamar
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.adminIndex')->with('success', 'Kamar berhasil dihapus!');
    }

    /**
     * Statistik kamar
     */
    public function stats()
    {
        $totalRooms = Room::count();
        $currentlyOccupied = Checkin::where('status', 'Active')->count();
        $availableRooms = $totalRooms - $currentlyOccupied;
        $emptyRooms = Room::where('status', 'Available')->count();

        $todayUsed = Checkin::whereDate('checkin_date', now()->toDateString())
            ->where('status', 'Active')
            ->count();

        $monthUsed = Checkin::whereMonth('checkin_date', now()->month)
            ->whereYear('checkin_date', now()->year)
            ->where('status', 'Active')
            ->count();

        return response()->json([
            'totalRooms' => $totalRooms,
            'todayUsed' => $todayUsed,
            'monthUsed' => $monthUsed,
            'availableRooms' => $availableRooms,
            'emptyRooms' => $emptyRooms,
        ]);
    }

    /**
     * Check In kamar
     */
    public function checkIn($id)
    {
        $room = Room::findOrFail($id);

        if ($room->status !== 'Available') {
            return redirect()->back()->with('error', 'Kamar tidak tersedia untuk check-in!');
        }

        $room->status = 'Occupied';
        $room->save();

        return redirect()->back()->with('success', 'Check-in berhasil!');
    }

    /**
     * Check Out kamar
     */
    public function checkOut($id)
    {
        $room = Room::findOrFail($id);

        if ($room->status !== 'Occupied') {
            return redirect()->back()->with('error', 'Kamar tidak sedang dipakai!');
        }

        $room->status = 'Cleaning';
        $room->save();

        return redirect()->back()->with('success', 'Check-out berhasil! Kamar kini dalam status Cleaning.');
    }

    /**
     * Update status kamar (Cleaning, Available, Locked)
     */
    public function updateStatus(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $status = ucfirst(strtolower($request->input('status')));

        $validStatus = ['Available', 'Cleaning', 'Locked', 'Occupied'];
        if (!in_array($status, $validStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid!');
        }

        $room->status = $status;
        $room->save();

        return redirect()->back()->with('success', 'Status kamar diperbarui!');
    }
}
