<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Tampilkan daftar laporan keuangan
     */
    public function index()
    {
        $finances = Finance::orderBy('date', 'desc')->paginate(20);
        $totalIncome = Finance::income()->sum('amount');
        $totalExpense = Finance::expense()->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('finance.index', compact('finances', 'totalIncome', 'totalExpense', 'balance'));
    }

    /**
     * Form tambah transaksi keuangan
     */
    public function create()
    {
        return view('finance.create');
    }

    /**
     * Simpan transaksi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'date'        => 'required|date',
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric',
            'type'        => 'required|in:income,expense',
        ]);

        Finance::create($request->all());

        return redirect()->route('finance.index')->with('success', 'Transaksi keuangan berhasil ditambahkan');
    }

    /**
     * Tampilkan detail transaksi
     */
    public function show(Finance $finance)
    {
        return view('finance.show', compact('finance'));
    }

    /**
     * Form edit transaksi
     */
    public function edit(Finance $finance)
    {
        return view('finance.edit', compact('finance'));
    }

    /**
     * Update transaksi
     */
    public function update(Request $request, Finance $finance)
    {
        $request->validate([
            'date'        => 'required|date',
            'description' => 'required|string|max:255',
            'amount'      => 'required|numeric',
            'type'        => 'required|in:income,expense',
        ]);

        $finance->update($request->all());

        return redirect()->route('finance.index')->with('success', 'Transaksi keuangan berhasil diperbarui');
    }

    /**
     * Hapus transaksi
     */
    public function destroy(Finance $finance)
    {
        $finance->delete();

        return redirect()->route('finance.index')->with('success', 'Transaksi keuangan berhasil dihapus');
    }
}
