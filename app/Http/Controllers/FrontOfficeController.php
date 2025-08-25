<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;

class FrontOfficeController extends Controller
{
    public function index()
    {
        $guests = Guest::all();
        return view('frontoffice.index', compact('guests'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('frontoffice.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date',
        ]);

        Guest::create($request->all());
        return redirect()->route('frontoffice.index')->with('success', 'Tamu berhasil ditambahkan');
    }

    public function show($id)
    {
        $guest = Guest::findOrFail($id);
        return view('frontoffice.show', compact('guest'));
    }

    public function edit($id)
    {
        $guest = Guest::findOrFail($id);
        $rooms = Room::all();
        return view('frontoffice.edit', compact('guest', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date',
        ]);

        $guest->update($request->all());
        return redirect()->route('frontoffice.index')->with('success', 'Data tamu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->delete();
        return redirect()->route('frontoffice.index')->with('success', 'Tamu berhasil dihapus');
    }
}
