<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerAuthController;
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

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// ================== AUTH ADMIN ==================
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});

// ================== AUTH OWNER ==================
Route::prefix('owner')->group(function () {
    Route::get('/login', [OwnerAuthController::class, 'showLoginForm'])->name('owner.login.form');
    Route::post('/login', [OwnerAuthController::class, 'login'])->name('owner.login');
    Route::post('/logout', [OwnerAuthController::class, 'logout'])->name('owner.logout');
    Route::get('/dashboard', [OwnerAuthController::class, 'dashboard'])
        ->middleware('auth:owner')
        ->name('owner.dashboard');
});

// ================== ADMIN / FRONT OFFICE ==================
Route::middleware(['auth'])->group(function () {

    // ---------- Profile ----------
    Route::prefix('profile')->group(function () {
        Route::get('edit', [AdminController::class, 'editProfile'])->name('profile.edit');
        Route::put('update', [AdminController::class, 'updateProfile'])->name('profile.update');
    });

    // ---------- Dashboard ----------
    Route::get('/dashboard', [RoomController::class, 'index'])->name('dashboard');

    // ---------- Rooms ----------
    Route::prefix('rooms')->group(function () {
        Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('/{room}', [RoomController::class, 'show'])->name('rooms.show');
        Route::get('/admin', [RoomController::class, 'adminIndex'])->name('rooms.adminIndex');
        Route::get('/stats', [RoomController::class, 'stats'])->name('rooms.stats');
        Route::get('/{room}/barcode', [RoomController::class, 'barcode'])->name('rooms.barcode');
        Route::post('/{id}/lock', [RoomController::class, 'lockWithBarcode'])->name('rooms.lockWithBarcode');
        Route::post('/{room}/owner-short-open', [RoomController::class, 'ownerShortOpen'])->name('rooms.ownerShortOpen');
        Route::match(['put', 'patch'], '/{id}/status', [RoomController::class, 'updateStatus'])->name('rooms.updateStatus');

        // Resource routes, excluding index karena sudah ada
        Route::resource('/', RoomController::class)->except(['index']);
    });

    // ---------- Keys ----------
    Route::prefix('keys')->group(function () {
        Route::get('/', [KeyController::class, 'index'])->name('keys.index');
        Route::post('/{room}/regenerate', [KeyController::class, 'regenerate'])->name('keys.regenerate');
        Route::post('/scan', [KeyController::class, 'scan'])->name('keys.scan');
        Route::get('/{key}/barcode', [KeyController::class, 'showBarcode'])->name('keys.barcode');
    });

    // ---------- Check-ins ----------
    Route::prefix('checkins')->group(function () {
        Route::get('/', [CheckInController::class, 'index'])->name('checkin.index');
        Route::get('/{room}/create', [CheckInController::class, 'create'])->name('checkins.create');
        Route::post('/{room}', [CheckInController::class, 'store'])->name('checkin'); // manual check-in
        Route::post('/barcode', [CheckInController::class, 'checkInBarcode'])->name('checkin.barcode'); // barcode
        Route::get('/{checkin}', [CheckInController::class, 'show'])->name('checkins.show');
        Route::get('/invoice/{checkin}', [CheckInController::class, 'invoice'])->name('checkins.invoice');
    });

    // ---------- Check-outs ----------
    Route::post('/checkout/{room}', [CheckOutController::class, 'store'])->name('checkout');

    // ---------- Shifts ----------
    Route::prefix('shifts')->group(function () {
        Route::get('/', [ShiftController::class, 'index'])->name('shifts.index');
        Route::post('/open', [ShiftController::class, 'open'])->name('shifts.open');
        Route::post('/handover-scan', [ShiftController::class, 'handoverScan'])->name('shifts.handoverScan');
        Route::post('/{shift}/close', [ShiftController::class, 'close'])->name('shifts.close');
    });

    // ---------- HRD ----------
    Route::prefix('hrd')->group(function () {
        Route::get('/', [HRDController::class, 'index'])->name('hrd.index');
        Route::post('/', [HRDController::class, 'store'])->name('hrd.store');
        Route::put('/{employee}', [HRDController::class, 'update'])->name('hrd.update');
        Route::delete('/{employee}', [HRDController::class, 'destroy'])->name('hrd.destroy');
    });

    // ---------- Restaurant ----------
    Route::prefix('restaurant')->group(function () {
        Route::get('/', [RestaurantController::class, 'index'])->name('restaurant.index');
        Route::post('/', [RestaurantController::class, 'store'])->name('restaurant.store');
    });

    // ---------- Laundry ----------
    Route::prefix('laundry')->group(function () {
        Route::get('/', [LaundryController::class, 'index'])->name('laundry.index');
        Route::post('/', [LaundryController::class, 'store'])->name('laundry.store');
    });

    // ---------- Finance ----------
    Route::prefix('finance')->middleware('auth')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('finance.index');
        Route::get('/create', [FinanceController::class, 'create'])->name('finance.create');
        Route::post('/', [FinanceController::class, 'store'])->name('finance.store');
        Route::get('/{finance}/edit', [FinanceController::class, 'edit'])->name('finance.edit');
        Route::put('/{finance}', [FinanceController::class, 'update'])->name('finance.update');
        Route::delete('/{finance}', [FinanceController::class, 'destroy'])->name('finance.destroy');
    });

    // ---------- Guests ----------
    Route::resource('guests', GuestController::class)->only(['index', 'store']);
});
