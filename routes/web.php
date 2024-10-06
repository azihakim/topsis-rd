<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\UmkmController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// dd
Route::middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('karyawan', KaryawanController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('subkriteria', SubKriteriaController::class);

    Route::resource('penilaian', PenilaianController::class);
});
Route::get('/umkm-dashboardAdmin', [UmkmController::class, 'dashboardAdmin'])->name('umkm.dashboardAdmin');

// Route::resource('umkm', UmkmController::class);
Route::get('/', [UmkmController::class, 'index'])->name('umkm.index');
Route::get('/umkm-dashboard', [UmkmController::class, 'dashboard'])->name('umkm.dashboard');
Route::get('/umkm/regist', [UmkmController::class, 'regist'])->name('umkm.regist');
Route::get('/umkm/addUsaha', [UmkmController::class, 'addUsaha'])->name('umkm.addUsaha');
Route::post('/umkm/storeUsaha', [UmkmController::class, 'storeUsaha'])->name('umkm.storeUsaha');
Route::get('/umkm/regist/store', [UmkmController::class, 'storeRegist'])->name('umkm.storeRegist');

Route::get('/umkm/detail/{id}', [UmkmController::class, 'umkmDetail'])->name('umkm.detail');

require __DIR__ . '/auth.php';
