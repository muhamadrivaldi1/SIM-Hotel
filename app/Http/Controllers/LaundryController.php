<?php

namespace App\Http\Controllers;

use App\Models\LaundryOrder;
use App\Models\Room;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
    public function index()
    {
        $orders = LaundryOrder::with('room')->latest()->get();
        return view('laundry.index', compact('orders'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('laundry.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'item' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.1',
            'price_per_kg' => 'required|numeric|min:0'
        ]);

        LaundryOrder::create([
            'room_id' => $request->room_id,
            'item' => $request->item,
            'weight' => $request->weight,
            'price_per_kg' => $request->price_per_kg,
            'total' => $request->weight * $request->price_per_kg,
        ]);

        return redirect()->route('laundry.index')->with('success', 'Pesanan laundry berhasil ditambahkan!');
    }

    public function show(LaundryOrder $laundryOrder)
    {
        return view('laundry.show', compact('laundryOrder'));
    }

    public function edit(LaundryOrder $laundryOrder)
    {
        $rooms = Room::all();
        return view('laundry.edit', compact('laundryOrder', 'rooms'));
    }

    public function update(Request $request, LaundryOrder $laundryOrder)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'item' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.1',
            'price_per_kg' => 'required|numeric|min:0'
        ]);

        $laundryOrder->update([
            'room_id' => $request->room_id,
            'item' => $request->item,
            'weight' => $request->weight,
            'price_per_kg' => $request->price_per_kg,
            'total' => $request->weight * $request->price_per_kg,
        ]);

        return redirect()->route('laundry.index')->with('success', 'Pesanan laundry berhasil diperbarui!');
    }

    public function destroy(LaundryOrder $laundryOrder)
    {
        $laundryOrder->delete();
        return redirect()->route('laundry.index')->with('success', 'Pesanan laundry berhasil dihapus!');
    }
}
