<?php

namespace App\Http\Controllers;

use App\Models\HRDEmployee;
use Illuminate\Http\Request;

class HRDController extends Controller
{
    public function index()
    {
        return response()->json(HRDEmployee::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'position' => 'required|string|max:100',
            'salary' => 'required|numeric',
        ]);

        $employee = HRDEmployee::create($validated);
        return response()->json(['message' => 'Karyawan berhasil ditambahkan', 'data' => $employee], 201);
    }

    public function show($id)
    {
        return response()->json(HRDEmployee::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $employee = HRDEmployee::findOrFail($id);
        $validated = $request->validate([
            'name' => 'nullable|string|max:150',
            'position' => 'nullable|string|max:100',
            'salary' => 'nullable|numeric',
        ]);

        $employee->update($validated);
        return response()->json(['message' => 'Data karyawan berhasil diperbarui', 'data' => $employee]);
    }

    public function destroy($id)
    {
        $employee = HRDEmployee::findOrFail($id);
        $employee->delete();
        return response()->json(['message' => 'Karyawan berhasil dihapus']);
    }
}
