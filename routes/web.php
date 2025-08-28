<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\HRDController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\OwnerAuthController;

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// ================== AUTH ADMIN ==================
Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// ================== AUTH OWNER ==================
Route::get('/owner/login', [OwnerAuthController::class, 'showLoginForm'])->name('owner.login.form');
Route::post('/owner/login', [OwnerAuthController::class, 'login'])->name('owner.login');
Route::post('/owner/logout', [OwnerAuthController::class, 'logout'])->name('owner.logout');
Route::get('/owner/dashboard', [OwnerAuthController::class, 'dashboard'])
    ->name('owner.dashboard')
    ->middleware('auth:owner');

// ================== ADMIN / FRONT OFFICE ==================
Route::middleware(['auth'])->group(function () {

    // ---------- Profile ----------
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    // ---------- Dashboard ----------
    Route::get('/dashboard', [RoomController::class, 'index'])->name('dashboard');

    // ---------- Rooms ----------
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/admin', [RoomController::class, 'adminIndex'])->name('rooms.adminIndex');
    Route::resource('rooms', RoomController::class)->except(['index']);
    Route::match(['put', 'patch'], '/rooms/{id}/status', [RoomController::class, 'updateStatus'])->name('rooms.updateStatus');
    Route::get('/rooms/stats', [RoomController::class, 'stats'])->name('rooms.stats');
    Route::get('/rooms/{room}/barcode', [RoomController::class, 'barcode'])->name('rooms.barcode');
    Route::post('/rooms/{id}/lock', [RoomController::class, 'lockWithBarcode'])->name('rooms.lockWithBarcode');
    Route::post('/rooms/{room}/owner-short-open', [RoomController::class, 'ownerShortOpen'])->name('rooms.ownerShortOpen');

    // ---------- Keys ----------
    Route::get('/keys', [KeyController::class, 'index'])->name('keys.index');
    Route::post('/keys/{room}/regenerate', [KeyController::class, 'regenerate'])->name('keys.regenerate');
    Route::post('/keys/scan', [KeyController::class, 'scan'])->name('keys.scan');
    Route::get('/keys/{key}/barcode', [KeyController::class, 'showBarcode'])->name('keys.barcode');

    // ---------- Check-ins ----------
    Route::get('/checkins', [CheckInController::class, 'index'])->name('checkin.index'); // halaman daftar kamar
    Route::get('/checkins/{room}/create', [CheckInController::class, 'create'])->name('checkins.create');
    Route::post('/checkins/{room}', [CheckInController::class, 'store'])->name('checkin'); // check-in manual
    Route::post('/checkin/barcode', [CheckInController::class, 'checkInBarcode'])->name('checkin.barcode'); // check-in via barcode
    Route::get('/checkins/{checkin}', [CheckInController::class, 'show'])->name('checkins.show');
    Route::get('/invoice/{checkin}', [CheckInController::class, 'invoice'])->name('checkins.invoice');

    // ---------- Check-outs ----------
    Route::post('/checkout/{room}', [CheckOutController::class, 'store'])->name('checkout');


    // ---------- Shifts ----------
    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::post('/shifts/open', [ShiftController::class, 'open'])->name('shifts.open');
    Route::post('/shifts/handover-scan', [ShiftController::class, 'handoverScan'])->name('shifts.handoverScan');
    Route::post('/shifts/{shift}/close', [ShiftController::class, 'close'])->name('shifts.close');

    // ---------- HRD ----------
    Route::get('/hrd', [HRDController::class, 'index'])->name('hrd.index');
    Route::post('/hrd', [HRDController::class, 'store'])->name('hrd.store');
    Route::put('/hrd/{employee}', [HRDController::class, 'update'])->name('hrd.update');
    Route::delete('/hrd/{employee}', [HRDController::class, 'destroy'])->name('hrd.destroy');

    // ---------- Restaurant ----------
    Route::get('/restaurant', [RestaurantController::class, 'index'])->name('restaurant.index');
    Route::post('/restaurant', [RestaurantController::class, 'store'])->name('restaurant.store');

    // ---------- Laundry ----------
    Route::get('/laundry', [LaundryController::class, 'index'])->name('laundry.index');
    Route::post('/laundry', [LaundryController::class, 'store'])->name('laundry.store');

    // ---------- Finance ----------
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance/daily', [FinanceController::class, 'daily'])->name('finance.daily');

    // ---------- Guests ----------
    Route::resource('guests', GuestController::class)->only(['index', 'store']);
});
