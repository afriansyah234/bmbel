<?php

use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\PengajarController;
use App\Http\Controllers\MapelController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

route::middleware(['auth'])->group(function () {
    Route::resource('pengajar', PengajarController::class);
    Route::resource('mapel', MapelController::class);
    route::resource('kelas', KelasController::class);
    route::resource('jadwal', JadwalController::class);
    route::resource('pendaftar', PendaftarController::class);
    route::resource('pembayaran', PembayaranController::class);
    Route::get('/pembayaran/riwayat', [PembayaranController::class, 'riwayat'])->name('pembayaran.riwayat');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
