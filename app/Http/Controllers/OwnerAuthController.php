<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CheckIn;

class OwnerAuthController extends Controller
{
    // Login owner via form atau AJAX
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Gunakan guard 'owner'
        if (Auth::guard('owner')->attempt($credentials)) {
            $request->session()->regenerate();

            // Jika login via AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('owner.dashboard'),
                ]);
            }

            return redirect()->route('owner.dashboard');
        }

        // Jika login gagal
        $error = ['username' => 'Username atau password salah!'];
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $error['username'],
            ]);
        }

        return back()->withErrors($error);
    }

    // Logout owner
    public function logout(Request $request)
    {
        Auth::guard('owner')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('owner.login.form');
    }

    // Dashboard owner
    public function dashboard()
    {
        // Statistik kamar saat load dashboard
        $roomsUsedToday = CheckIn::whereDate('created_at', now()->toDateString())->count();
        $roomsUsedMonth = CheckIn::whereMonth('created_at', now()->month)->count();

        // Data grafik bulanan
        $labels = [];
        $visitorData = [];
        $revenueData = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('F', mktime(0, 0, 0, $i, 1));
            $visitorData[] = CheckIn::whereMonth('created_at', $i)->count();
            $revenueData[] = CheckIn::whereMonth('created_at', $i)->sum('total_price'); // pastikan kolom total_price ada
        }

        return view('owner.dashboard', compact(
            'roomsUsedToday',
            'roomsUsedMonth',
            'labels',
            'visitorData',
            'revenueData'
        ));
    }

    // Endpoint AJAX untuk update real-time kamar
    // Endpoint AJAX untuk update real-time kamar
    public function roomsUsage()
    {
        $today = now()->toDateString();
        $startOfMonth = now()->startOfMonth()->toDateString();

        $roomsUsedToday = CheckIn::whereDate('created_at', $today)->count();
        $roomsUsedMonth = CheckIn::whereDate('created_at', '>=', $startOfMonth)->count();

        return response()->json([
            'roomsUsedToday' => $roomsUsedToday,
            'roomsUsedMonth' => $roomsUsedMonth,
        ]);
    }
}
