<?php

namespace App\Http\Controllers;

use App\Models\RestaurantOrder;
use App\Models\Room;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $orders = RestaurantOrder::with('room')->latest()->get();
        return view('restaurant.index', compact('orders'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('restaurant.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'item' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        RestaurantOrder::create([
            'room_id' => $request->room_id,
            'item' => $request->item,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
        ]);

        return redirect()->route('restaurant.index')->with('success', 'Pesanan restoran berhasil ditambahkan!');
    }

    public function show(RestaurantOrder $restaurantOrder)
    {
        return view('restaurant.show', compact('restaurantOrder'));
    }

    public function edit(RestaurantOrder $restaurantOrder)
    {
        $rooms = Room::all();
        return view('restaurant.edit', compact('restaurantOrder', 'rooms'));
    }

    public function update(Request $request, RestaurantOrder $restaurantOrder)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'item' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $restaurantOrder->update([
            'room_id' => $request->room_id,
            'item' => $request->item,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'total' => $request->quantity * $request->price,
        ]);

        return redirect()->route('restaurant.index')->with('success', 'Pesanan restoran berhasil diperbarui!');
    }

    public function destroy(RestaurantOrder $restaurantOrder)
    {
        $restaurantOrder->delete();
        return redirect()->route('restaurant.index')->with('success', 'Pesanan restoran berhasil dihapus!');
    }
}
