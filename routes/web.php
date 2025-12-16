<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceOrderController;
use App\Http\Controllers\OwnershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- AREA ADMIN (Staff) ---
    // Perhatikan: Kita pakai alias 'admin' yang baru dibuat
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        Route::resource('users', UserController::class);
        // Pastikan Controller ini sudah dibuat (UnitController)
        Route::resource('units', UnitController::class);

        Route::resource('technicians', TechnicianController::class);

        Route::resource('customers', CustomerController::class);
        // Uncomment nanti kalau controllernya sudah dibuat
        Route::resource('ownerships', OwnershipController::class);

        // MAINTENANCE (ADMIN)
        Route::get('maintenance', [MaintenanceOrderController::class, 'indexAdmin'])->name('maintenance.index');
        Route::get('maintenance/{id}', [MaintenanceOrderController::class, 'showAdmin'])->name('maintenance.show');
        Route::put('maintenance/{id}/assign', [MaintenanceOrderController::class, 'updateStatus'])->name('maintenance.update');
    });

    // --- AREA NASABAH & WARGA ---
    // Uncomment nanti kalau controllernya sudah dibuat
    // Route::get('/my-assets', [OwnershipController::class, 'myAssets'])->name('my.assets');

    Route::get('/complaints', [MaintenanceOrderController::class, 'indexUser'])->name('complaints.index');
    Route::get('/complaints/create', [MaintenanceOrderController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [MaintenanceOrderController::class, 'store'])->name('complaints.store');
    Route::get('/complaints/{id}', [MaintenanceOrderController::class, 'showUser'])->name('complaints.show');
    Route::put('/complaints/{id}/rate', [MaintenanceOrderController::class, 'rateService'])->name('complaints.rate');
});

require __DIR__.'/auth.php';
