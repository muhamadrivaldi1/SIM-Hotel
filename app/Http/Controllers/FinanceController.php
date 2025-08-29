<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::orderBy('date', 'desc')->paginate(10);
        return view('finance.index', compact('finances'));
    }

    public function create()
    {
        return view('finance.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_type' => 'required|in:Income,Expense',
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Finance::create($validated);

        return redirect()->route('finance.index')->with('success', 'Transaction added successfully.');
    }

    public function edit(Finance $finance)
    {
        return view('finance.edit', compact('finance'));
    }

    public function update(Request $request, Finance $finance)
    {
        $validated = $request->validate([
            'transaction_type' => 'required|in:Income,Expense',
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $finance->update($validated);

        return redirect()->route('finance.index')->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();
        return redirect()->route('finance.index')->with('success', 'Transaction deleted successfully.');
    }
}
