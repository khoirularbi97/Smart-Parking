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
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopupController;
use App\Models\Member;
use App\Models\ParkirMasuk;
use App\Models\Transaksi;
use App\Http\Controllers\TopupAdminController;

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

    //route Parkir masuk
    Route::get('/parkir_masuk', [ParkirMasukController::class, 'index'])->name('parkir.masuk');
    Route::delete('admin/parkir_masuk/{id}', [ParkirMasukController::class, 'destroy'])->name('admin.parkir_masuk.destroy');

    //route Parkir Keluar
    Route::get('/parkir_keluar', [ParkirMasukController::class, 'index'])->name('parkir.keluar');
    Route::delete('admin/parkir_keluar/{id}', [ParkirMasukController::class, 'destroy'])->name('admin.parkir_keluar.destroy');
    //route TopUp
    Route::get('/topup/admin', [TopupAdminController::class, 'index'])->name('topup.admin');

    Route::get('/riwayat_parkir', [ParkirMasukController::class, 'index'])->name('riwayat.parkir');

    // print
    Route::get('/admin/transaksis/export-pdf', [TransaksiController::class, 'exportPdf'])->name('admin.transaksis.exportPdf');
    Route::get('/admin/transaksis/chart-preview', [TransaksiController::class, 'chartPreview'])->name('admin.transaksis.chartPreview');

    Route::post('/admin/transaksi/export-pdf', [TransaksiController::class, 'exportPDF2'])->name('admin.transaksi.export-pdf');

    //topup
    //Route::post('/topup', [TopupController::class, 'process'])->name('topup.process');
    // Route::post('/topup/callback', [App\Http\Controllers\TopupController::class, 'callback']);

   
});






require __DIR__.'/auth.php';
