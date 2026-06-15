<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\Admin\PermohonanAdminController;

// Route untuk warga (guest)
Route::get('/portal', function () {
    return view('portal');
})->name('portal');
Route::get('/', [PermohonanController::class, 'dashboard'])->name('permohonan.dashboard');

Route::prefix('surat')->name('surat.')->group(function () {
    Route::get('/tidak-mampu', [PermohonanController::class, 'tidakMampu'])->name('tidak-mampu');
    Route::post('/tidak-mampu', [PermohonanController::class, 'storeTidakMampu'])->name('store.tidak-mampu');
    Route::get('/kematian', [PermohonanController::class, 'kematian'])->name('kematian');
    Route::post('/kematian', [PermohonanController::class, 'storeKematian'])->name('store.kematian');
    Route::get('/status/{tipe}/{token}', [PermohonanController::class, 'status'])->name('status');
    Route::get('/cek-status', [PermohonanController::class, 'cekStatus'])->name('cek-status');
    Route::get('/download/{tipe}/{token}', [PermohonanController::class, 'download'])->name('download');
});

// Route untuk RT
Route::prefix('rt')->name('rt.')->group(function () {

    Route::middleware('guest:rt')->group(function () {
        Route::get('/login', [App\Http\Controllers\RT\AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [App\Http\Controllers\RT\AuthController::class, 'login']);
    });

    Route::middleware('auth:rt')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\RT\PermohonanRtController::class, 'index'])->name('dashboard');
        Route::post('/logout', [App\Http\Controllers\RT\AuthController::class, 'logout'])->name('logout');

        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/{tipe}/{id}', [App\Http\Controllers\RT\PermohonanRtController::class, 'show'])->name('show');
            Route::post('/{tipe}/{id}/approve', [App\Http\Controllers\RT\PermohonanRtController::class, 'approve'])->name('approve');
            Route::post('/{tipe}/{id}/reject', [App\Http\Controllers\RT\PermohonanRtController::class, 'reject'])->name('reject');
        });
    });
});

// Route untuk admin
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/download/{tipe}/{token}', [PermohonanAdminController::class, 'download'])->name('download');

        Route::prefix('rt-management')->name('rt.management.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\RtManagementController::class, 'index'])->name('index');
            Route::get('/{id}', [App\Http\Controllers\Admin\RtManagementController::class, 'show'])->name('show');
            Route::post('/{id}/toggle-active', [App\Http\Controllers\Admin\RtManagementController::class, 'toggleActive'])->name('toggle-active');
            Route::post('/{id}/reset-password', [App\Http\Controllers\Admin\RtManagementController::class, 'resetPassword'])->name('reset-password');
        });

        Route::prefix('permohonan')->name('permohonan.')->group(function () {
            Route::get('/', [PermohonanAdminController::class, 'index'])->name('index');
            Route::get('/{tipe}/{id}', [PermohonanAdminController::class, 'show'])->name('show');
            Route::post('/{tipe}/{id}/approve', [PermohonanAdminController::class, 'approve'])->name('approve');
            Route::post('/{tipe}/{id}/reject', [PermohonanAdminController::class, 'reject'])->name('reject');
        });
    });
});