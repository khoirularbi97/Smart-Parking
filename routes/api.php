<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\KendaraanController;
// use App\Http\Controllers\ParkirMasukController;
// use App\Http\Controllers\ParkirKeluarController;
// use App\Http\Controllers\PembayaranController;
// use App\Http\Controllers\LogNotifikasiController;
// use App\Http\Controllers\RiwayatParkirController;
use App\Http\Controllers\MidtransController;
// use App\Http\Controllers\TopupController;

// Route::apiResource('kendaraan', KendaraanController::class);
// Route::apiResource('parkir-masuk', ParkirMasukController::class);
// Route::apiResource('parkir-keluar', ParkirKeluarController::class);
// Route::apiResource('pembayaran', PembayaranController::class);
// Route::apiResource('log-notifikasi', LogNotifikasiController::class);
// Route::apiResource('riwayat-parkir', RiwayatParkirController::class);




// // Route::post('/midtrans/callback', [TopupController::class, 'callback']);

// Route::post('/anpr', function (Request $request) {
//     // Simpan gambar atau proses ANPR
//     $image = $request->input('image');
//     // Simpan ke database atau proses lainnya
//     return response()->json(['status' => 'received']);
// });

// Route::post('/payment', function (Request $request) {
//     $uid = $request->input('uid');

//     // Cek UID dan proses pembayaran
//     $status = 'success'; // atau cek dari database

//     return response()->json(['status' => $status]);
// });
// routes/api.php
Route::post('/midtrans/callbacks', [MidtransController::class, 'notificationHandler']);

