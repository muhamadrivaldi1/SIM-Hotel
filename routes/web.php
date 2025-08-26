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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', fn() => redirect()->route('login'));

// Login / Logout
Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// Routes untuk user yang sudah login
Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

    // Dashboard Front Office (pagination)
    Route::get('/dashboard', [RoomController::class, 'index'])->name('dashboard');

    // Admin rooms (lihat semua kamar)
    Route::get('/rooms/admin', [RoomController::class, 'adminIndex'])->name('rooms.adminIndex');

    // Rooms resource (CRUD)
    Route::resource('rooms', RoomController::class)->except(['index']); // index admin sudah khusus

    // Update status kamar
    Route::match(['put', 'patch'], '/rooms/{id}/status', [RoomController::class, 'updateStatus'])->name('rooms.updateStatus');

    // Lock room via barcode
    Route::post('/rooms/{id}/lock', [RoomController::class, 'lockWithBarcode'])->name('rooms.lockWithBarcode');   
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');


    // Optional owner short open (jika ada)
    Route::post('/rooms/{room}/owner-short-open', [RoomController::class, 'ownerShortOpen'])->name('rooms.ownerShortOpen');

    // Keys
    Route::get('/keys', [KeyController::class, 'index'])->name('keys.index');
    Route::post('/keys/{room}/regenerate', [KeyController::class, 'regenerate'])->name('keys.regenerate');
    Route::post('/keys/scan', [KeyController::class, 'scan'])->name('keys.scan');
    Route::get('/keys/{key}/barcode', [KeyController::class, 'showBarcode'])->name('keys.barcode');

    // Check-ins
    Route::get('/checkins', [CheckInController::class, 'index'])->name('checkins.index');
    Route::get('/checkins/{room}/create', [CheckInController::class, 'create'])->name('checkins.create');
    Route::post('/checkin/{room}', [CheckInController::class, 'store'])->name('checkin');
    Route::get('/checkins/{checkin}', [CheckInController::class, 'show'])->name('checkins.show');
    Route::get('/invoice/{checkin}', [CheckInController::class, 'invoice'])->name('checkins.invoice');

    // Check-outs
    Route::get('/checkouts', [CheckOutController::class, 'index'])->name('checkouts.index');
    Route::post('/checkouts/{checkin}', [CheckOutController::class, 'store'])->name('checkouts.store');
    Route::post('/checkout/{room}', [CheckOutController::class, 'store'])->name('checkout');


    // Shifts
    Route::get('/shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::post('/shifts/open', [ShiftController::class, 'open'])->name('shifts.open');
    Route::post('/shifts/handover-scan', [ShiftController::class, 'handoverScan'])->name('shifts.handoverScan');
    Route::post('/shifts/{shift}/close', [ShiftController::class, 'close'])->name('shifts.close');

    // HRD
    Route::get('/hrd', [HRDController::class, 'index'])->name('hrd.index');
    Route::post('/hrd', [HRDController::class, 'store'])->name('hrd.store');
    Route::put('/hrd/{employee}', [HRDController::class, 'update'])->name('hrd.update');
    Route::delete('/hrd/{employee}', [HRDController::class, 'destroy'])->name('hrd.destroy');

    // Restaurant
    Route::get('/restaurant', [RestaurantController::class, 'index'])->name('restaurant.index');
    Route::post('/restaurant', [RestaurantController::class, 'store'])->name('restaurant.store');

    // Laundry
    Route::get('/laundry', [LaundryController::class, 'index'])->name('laundry.index');
    Route::post('/laundry', [LaundryController::class, 'store'])->name('laundry.store');

    // Finance
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/finance/daily', [FinanceController::class, 'daily'])->name('finance.daily');

    // Guests
    Route::resource('guests', GuestController::class)->only(['index', 'store']);
});
