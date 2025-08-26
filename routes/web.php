<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontOfficeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\KeyController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\HRDController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\GuestController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login / Logout
Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login']);
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// Profile (kelola akun)
Route::middleware(['auth'])->group(function () {
    // Halaman edit profile
    Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
});

// Group route yang memerlukan login
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Rooms
    Route::resource('rooms', RoomController::class);
    Route::post('rooms/{room}/owner-short-open', [RoomController::class, 'ownerShortOpen'])->name('rooms.ownerShortOpen');


    Route::get('/keys', [KeyController::class, 'index'])->name('keys.index');
    Route::post('/keys/{room}/regenerate', [KeyController::class, 'regenerate'])->name('keys.regenerate');
    Route::post('/keys/scan', [KeyController::class, 'scan'])->name('keys.scan');
    Route::get('/keys/{key}/barcode', [KeyController::class, 'showBarcode'])->name('keys.barcode');

    // Checkins / Checkouts / Invoice
    Route::get('/checkins', [CheckinController::class, 'index'])->name('checkins.index');
    Route::get('/checkins/{room}/create', [CheckinController::class, 'create'])->name('checkins.create');
    Route::post('/checkins/{room}', [CheckinController::class, 'store'])->name('checkins.store');
    Route::get('/checkins/{checkin}', [CheckinController::class, 'show'])->name('checkins.show');
    Route::get('/checkouts', [CheckinController::class, 'checkoutIndex'])->name('checkout.index');
    Route::post('/checkouts/{checkin}', [CheckinController::class, 'checkout'])->name('checkins.checkout');
    Route::get('/invoice/{checkin}', [CheckinController::class, 'invoice'])->name('checkins.invoice');

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

    // Inventory (jika dibutuhkan)
    // Route::resource('inventory', InventoryController::class);

    // Guests (opsional, jika nanti digunakan)
    Route::resource('guests', GuestController::class)->only(['index', 'store']);
});
