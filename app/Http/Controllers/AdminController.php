<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Checkin;
use App\Models\User;


class AdminController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function loginForm(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    /**
     * Logout & Lock semua kamar
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Semua kamar yang sebelumnya Available jadi Locked
        Room::where('status', 'Available')->update(['status' => 'Locked']);

        // Logout user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Menampilkan dashboard
     */
    public function index(): \Illuminate\View\View
    {
        $rooms = Room::all();
        $guests = Guest::all();

        // Data chart dummy, bisa diganti dengan data nyata
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $chartData   = [1200, 1500, 1800, 1400, 2000, 2500, 2300, 2100, 2200, 2400, 2600, 2800];

        // Ambil 5 checkin terakhir
        $recentCheckins = Checkin::with(['guest', 'room'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('rooms', 'guests', 'chartLabels', 'chartData', 'recentCheckins'));
    }

    /**
     * Menampilkan halaman edit profile
     */
    public function editProfile(): \Illuminate\View\View
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile berhasil diperbarui');
    }
}
