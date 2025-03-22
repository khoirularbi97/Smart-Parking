<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\ParkirMasukController;
use App\Http\Controllers\ParkirKeluarController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LogNotifikasiController;
use App\Http\Controllers\RiwayatParkirController;

Route::apiResource('kendaraan', KendaraanController::class);
Route::apiResource('parkir-masuk', ParkirMasukController::class);
Route::apiResource('parkir-keluar', ParkirKeluarController::class);
Route::apiResource('pembayaran', PembayaranController::class);
Route::apiResource('log-notifikasi', LogNotifikasiController::class);
Route::apiResource('riwayat-parkir', RiwayatParkirController::class);

