<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\MaintenanceScheduleController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\OperationalInspectionController;
use App\Http\Controllers\ReportArmadaController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/**
 * Routing untuk Sistem Informasi Pemeliharaan Armada Bus
 *
 * Struktur route:
 * - Public routes: login, register (jika diperlukan)
 * - Protected routes: membutuhkan authentication
 * - Role-based routes: grouped berdasarkan role (admin, manager, mechanic)
 */

// ==================== PUBLIC ROUTES ====================
Route::middleware('guest')->group(function () {
    // Login routes (dari Laravel Breeze/Auth)
    Route::get('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // ========== DASHBOARD ==========
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    // ========== MONITORING ==========
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring.index');

    // ========== OPERATIONAL INSPECTIONS (AT/3 & AT/4) ==========
    Route::get('/at3/create', [OperationalInspectionController::class, 'createAt3'])->name('at3.create');
    Route::get('/at4/create', [OperationalInspectionController::class, 'createAt4'])->name('at4.create');

    Route::prefix('inspections')->name('inspections.')->group(function () {
        Route::get('/', [OperationalInspectionController::class, 'index'])->name('index');
        Route::get('at3/create', [OperationalInspectionController::class, 'createAt3'])->name('at3.create');
        Route::get('at4/create', [OperationalInspectionController::class, 'createAt4'])->name('at4.create');
        Route::post('at3', [OperationalInspectionController::class, 'storeAt3'])->name('at3.store');
        Route::post('at4', [OperationalInspectionController::class, 'storeAt4'])->name('at4.store');
        Route::get('{inspection}', [OperationalInspectionController::class, 'show'])->name('show');
        Route::get('{inspection}/edit', [OperationalInspectionController::class, 'edit'])->name('edit');
        Route::put('{inspection}', [OperationalInspectionController::class, 'update'])->name('update');
    });


    // Hanya Admin dan Manager yang bisa create/update/delete
    Route::middleware('role:admin,manager')->group(function () {
        Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
        });
        // ========== VEHICLES MANAGEMENT ==========
        // Semua role bisa akses vehicle list (dengan kondisi tertentu)
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

    // ========== MAINTENANCE SCHEDULES ==========
    Route::prefix('maintenance-schedules')->name('schedules.')->group(function () {

        // Hanya Admin dan Manager
        Route::middleware('role:admin,manager')->group(function () {
            Route::get('create', [MaintenanceScheduleController::class, 'create'])->name('create');
            Route::post('/', [MaintenanceScheduleController::class, 'store'])->name('store');
            Route::get('{schedule}/edit', [MaintenanceScheduleController::class, 'edit'])->name('edit');
            Route::put('{schedule}', [MaintenanceScheduleController::class, 'update'])->name('update');
            Route::delete('{schedule}', [MaintenanceScheduleController::class, 'destroy'])->name('destroy');
            });
            Route::get('/', [MaintenanceScheduleController::class, 'index'])->name('index');
            Route::get('{schedule}', [MaintenanceScheduleController::class, 'show'])->name('show');
            });

    // ========== MAINTENANCE RECORDS ==========
    Route::prefix('maintenance-records')->name('records.')->group(function () {

        // Hanya Admin dan Manager
        Route::middleware('role:admin,manager')->group(function () {
            Route::get('create', [MaintenanceRecordController::class, 'create'])->name('create');
            Route::post('/', [MaintenanceRecordController::class, 'store'])->name('store');
            Route::get('{record}/edit', [MaintenanceRecordController::class, 'edit'])->name('edit');
            Route::put('{record}', [MaintenanceRecordController::class, 'update'])->name('update');
            Route::delete('{record}', [MaintenanceRecordController::class, 'destroy'])->name('destroy');
            });
            Route::get('/', [MaintenanceRecordController::class, 'index'])->name('index');
            Route::get('{record}', [MaintenanceRecordController::class, 'show'])->name('show');
    });

    // ========== REPORTS ==========
    Route::middleware('role:admin,manager')->prefix('report')->name('report.')->group(function () {
        Route::get('/', [ReportArmadaController::class, 'dashboard'])->name('dashboard');

        Route::get('armada', [ReportArmadaController::class, 'armada'])->name('armada');
        Route::get('armada/export-excel', [ReportArmadaController::class, 'armadaExcel'])->name('armada.excel');
        Route::get('armada/export-pdf', [ReportArmadaController::class, 'armadaPdf'])->name('armada.pdf');

        Route::get('jadwal-servis', [ReportArmadaController::class, 'jadwalServis'])->name('jadwal-servis');
        Route::get('jadwal-servis/export-excel', [ReportArmadaController::class, 'jadwalServisExcel'])->name('jadwal-servis.excel');
        Route::get('jadwal-servis/export-pdf', [ReportArmadaController::class, 'jadwalServisPdf'])->name('jadwal-servis.pdf');

        Route::get('riwayat-pemeliharaan', [ReportArmadaController::class, 'riwayatPemeliharaan'])->name('riwayat-pemeliharaan');
        Route::get('riwayat-pemeliharaan/export-excel', [ReportArmadaController::class, 'riwayatPemeliharaanExcel'])->name('riwayat-pemeliharaan.excel');
        Route::get('riwayat-pemeliharaan/export-pdf', [ReportArmadaController::class, 'riwayatPemeliharaanPdf'])->name('riwayat-pemeliharaan.pdf');
        Route::get('riwayat-pemeliharaan/{armada}', [ReportArmadaController::class, 'detailRiwayatArmada'])->name('riwayat-pemeliharaan.detail');

        Route::get('keterlambatan-servis', [ReportArmadaController::class, 'keterlambatanServis'])->name('keterlambatan-servis');
        Route::get('keterlambatan-servis/export-excel', [ReportArmadaController::class, 'keterlambatanServisExcel'])->name('keterlambatan-servis.excel');
        Route::get('keterlambatan-servis/export-pdf', [ReportArmadaController::class, 'keterlambatanServisPdf'])->name('keterlambatan-servis.pdf');

        Route::get('kondisi-armada', [ReportArmadaController::class, 'kondisiArmada'])->name('kondisi-armada');
        Route::get('kondisi-armada/export-excel', [ReportArmadaController::class, 'kondisiArmadaExcel'])->name('kondisi-armada.excel');
        Route::get('kondisi-armada/export-pdf', [ReportArmadaController::class, 'kondisiArmadaPdf'])->name('kondisi-armada.pdf');
    });

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('generate', [ReportController::class, 'generate'])->name('generate');
        Route::get('export', [ReportController::class, 'export'])->name('export');
        Route::get('vehicle-cost-summary', [ReportController::class, 'vehicleCostSummary'])->name('vehicle-cost');
        Route::get('mechanic-performance', [ReportController::class, 'mechanicPerformance'])->name('mechanic-performance');
    });

    // ========== ADMIN ONLY ROUTES ==========
    Route::middleware('role:admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            // User Management (jika diperlukan)
            // Route::resource('users', UserController::class);
        });
    });
});
