<?php

namespace App\Http\Controllers;

use App\Models\HRDEmployee;
use Illuminate\Http\Request;

class HRDController extends Controller
{
    // Tampilkan daftar karyawan dengan pagination
    public function index()
    {
        $employees = HRDEmployee::paginate(10); // 10 data per halaman
        return view('hrd.index', compact('employees'));
    }

    // Simpan karyawan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:150',
            'position' => 'required|string|max:100',
            'salary'   => 'required|numeric',
            'status'   => 'nullable|in:Active,Inactive'
        ]);

        HRDEmployee::create($validated);

        return redirect()->route('hrd.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $employee = HRDEmployee::findOrFail($id);
        return view('hrd.edit', compact('employee'));
    }

    // Update karyawan
    public function update(Request $request, $id)
    {
        $employee = HRDEmployee::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:150',
            'position' => 'required|string|max:100',
            'salary'   => 'required|numeric',
            'status'   => 'required|in:Active,Inactive'
        ]);

        $employee->update($validated);

        return redirect()->route('hrd.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    // Hapus karyawan
    public function destroy($id)
    {
        $employee = HRDEmployee::findOrFail($id);
        $employee->delete();

        return redirect()->route('hrd.index')->with('success', 'Karyawan berhasil dihapus');
    }
}
