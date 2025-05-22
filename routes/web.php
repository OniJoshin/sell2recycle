<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\DeviceController;
use App\Http\Controllers\Admin\DeviceAliasController;
use App\Http\Controllers\VendorController as VendorDashboardController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;

Route::get('/', function () {
    return view('welcome');
});

// Authenticated group
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->getRoleNames()->first();

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            default => redirect()->route('user.dashboard'),
        };
    })->name('dashboard');

    // Admin Dashboard
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // Vendor Dashboard
    Route::middleware('role:vendor')->group(function () {
        Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
    });

    // User Dashboard
    Route::middleware('role:user')->group(function () {
        Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    });

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('devices', DeviceController::class);
    });
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('offers', OfferController::class);
    });
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('vendors', AdminVendorController::class);
    });
    Route::post('/vendors/{vendor}/refresh-feed', [AdminVendorController::class, 'refreshFeed'])
    ->name('admin.vendors.refreshFeed');
    Route::get('/vendors/{vendor}/offers', [AdminVendorController::class, 'showOffers'])
    ->name('admin.vendors.offers');
    Route::get('/vendors/{vendor}/unmatched', [AdminVendorController::class, 'viewUnmatchedRows'])
    ->name('admin.vendors.unmatched');
    Route::resource('aliases', DeviceAliasController::class)
        ->except(['show'])
        ->names('admin.aliases');







});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
