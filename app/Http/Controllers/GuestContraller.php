<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class GuestController extends Controller
{
    // Menampilkan semua guest
    public function index()
    {
        $guests = Guest::all();
        return view('admin.guests.index', compact('guests'));
    }

    // Menyimpan guest baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|string|max:50'
        ]);

        Guest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status ?? 'Checked In',
        ]);

        return redirect()->route('guests.index')->with('success', 'Guest berhasil ditambahkan');
    }
}
