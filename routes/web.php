<?php

use App\Http\Controllers\AdminController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ParkirMasukController;
use App\Http\Controllers\ParkirKeluarController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Models\Member;
use App\Models\ParkirMasuk;
use App\Models\Transaksi;
use App\Http\Controllers\TopupAdminController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\ParkingSlot;
use App\Http\Controllers\ParkingSlotController;
use App\Http\Controllers\RiwayatParkirController;
use App\Models\RiwayatParkir;

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

        // Cek apakah user sudah ada berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Login langsung jika user sudah terdaftar
            Auth::login($user);
        } else {
          // return redirect('login')->with('error', 'Email ini belum terdaftar.');
          $id = uniqid();
             $user = User::create([
                'name' => $googleUser->getName(),
                'uid' => $id,
                'saldo' => 0,
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)), // bisa dikunci random
            ]);

            Auth::login($user);
        }

        return redirect('/dashboard'); // arahkan setelah login

});
Route::get('/statistik-transaksi', function () {
    $data = DB::table('transaksi')
        ->select(DB::raw("jenis, SUM(jumlah) as total"))
        ->groupBy('jenis')
        ->get();

    return response()->json([
        "labels" => $data->pluck('jenis'),
        "values" => $data->pluck('total')
    ]);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/user', [ProfileUserController::class, 'edit'])->name('profile_user.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    
    Route::get('/topup', [TopupController::class, 'index'])->name('topup.form');

    Route::post('/topup/process', [TopupController::class, 'process'])->name('topup.process');

    Route::get('/api/midtrans/status/{orderId}', [MidtransController::class, 'checkStatus']);
    Route::get('/invoice/user/{order_id}', [TopupController::class, 'showInvoice'])->name('invoice.user.show');
   

    

// Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');



});
Route::middleware('auth','admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //route member
    Route::post('store', [MemberController::class, 'store'])->name('store');
    Route::put('/admin/member/{user}', [MemberController::class, 'update'])->name('admin.member.update');
    Route::get('/admin/member/{user}/edit', [MemberController::class, 'edit'])->name('admin.member.edit');
    Route::get('/member', [MemberController::class, 'index'])->name('admin.member');
    Route::get('admin/member/create', [MemberController::class, 'create'])->name('admin/member/create');
    Route::delete('/admin/member/{id}', [MemberController::class, 'destroy'])->name('admin.member.destroy');
    
    //route transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::get('admin/transaksi/create', [TransaksiController::class, 'create'])->name('admin/transaksi/create');
    Route::get('/admin/transaksi/{user}/edit', [TransaksiController::class, 'edit'])->name('admin.transaksi.edit');
    Route::post('store/transaksi', [TransaksiController::class, 'store'])->name('store.transaksi');
    Route::put('/admin/transaksi/{id}', [TransaksiController::class, 'update'])->name('admin.transaksi.update');
    Route::delete('/admin/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('admin.transaksi.destroy');
    Route::get('/admin/chart-keuntungan', [TransaksiController::class, 'chartKeuntunganBulanan'])->name('admin.chart.keuntungan');

    Route::post('/laporan/export', [TransaksiController::class, 'export'])->name('laporan.export');



    //route riwayat parkir
    Route::get('/riwayat-parkir', [RiwayatParkirController::class, 'index'])->name('riwayat.parkir');
    Route::get('admin/riwayat-parkir/create', [RiwayatParkirController::class, 'create'])->name('admin.riwayat-parkir.create');
    Route::get('/admin/riwayat-parkir/{user}/edit', [RiwayatParkirController::class, 'edit'])->name('admin.riwayat-parkir.edit');
    Route::post('store/riwayat-parkir', [RiwayatParkirController::class, 'store'])->name('store.riwayat-parkir');
    Route::put('/admin/riwayat-parkir/{id}', [RiwayatParkirController::class, 'update'])->name('admin.riwayat-parkir.update');
    Route::delete('/admin/riwayat-parking/{id}', [RiwayatParkirController::class, 'destroy'])->name('admin.riwayat-parking.destroy');

    //route Parkir masuk
    Route::get('/parkir_masuk', [ParkirMasukController::class, 'index'])->name('parkir.masuk');
    Route::delete('admin/parkir_masuk/{id}', [ParkirMasukController::class, 'destroy'])->name('admin.parkir_masuk.destroy');

    //route Parkir Keluar
    Route::get('/parkir_keluar', [ParkirKeluarController::class, 'index'])->name('parkir.keluar');
    Route::delete('admin/parkir_keluar/{id}', [ParkirKeluarController::class, 'destroy'])->name('admin.parkir_keluar.destroy');
    //route slot  parking
    Route::get('/slot_parking', [ParkingSlotController::class, 'index'])->name('parkir.slot');
    Route::delete('admin/parkir_slot/{id}', [ParkingSlotController::class, 'destroy'])->name('admin.parkir_slot.destroy');
    Route::post('/slot/store', [ParkingSlotController::class, 'store'])->name('slot.store');
    Route::put('/slot/update/{id}', [ParkingSlotController::class, 'update'])->name('slot.update');



    //route TopUp
    Route::get('/topup/admin', [TopupAdminController::class, 'index'])->name('topup.admin');
    Route::get('/topup/admin/create-topup', [TopupAdminController::class, 'create'])->name('create.topup');
    Route::get('/topup/admin/edit-topup{id}', [TopupAdminController::class, 'edit'])->name('edit.topup');
    Route::post('/topup/admin/proses', [TopupAdminController::class, 'process'])->name('admin.topup.process');
    Route::delete('/topup/admin/delete/{id}', [TopupAdminController::class, 'destroy'])->name('admin.topup.delete');
    Route::match(['get', 'post'], '/topup/admin/export-pdf', [TopupAdminController::class, 'exportPDF2'])->name('admin.topup.export-pdf');
    Route::get('/invoice/{order_id}', [TopupAdminController::class, 'showInvoice'])->name('invoice.show');



    // Route::get('/riwayat_parkir', [ParkirMasukController::class, 'index'])->name('riwayat.parkir');

    // print
    //Route::get('/admin/transaksis/export-pdf', [TransaksiController::class, 'exportPdf'])->name('admin.transaksis.exportPdf');
    //Route::get('/admin/transaksis/chart-preview', [TransaksiController::class, 'chartPreview'])->name('admin.transaksis.chartPreview');

    Route::post('/admin/transaksi/export-pdf', [TransaksiController::class, 'exportPDF2'])->name('admin.transaksi.export-pdf');

    //topup
    //Route::post('/topup', [TopupController::class, 'process'])->name('topup.process');
    // Route::post('/topup/callback', [App\Http\Controllers\TopupController::class, 'callback']);

   
});






require __DIR__.'/auth.php';
