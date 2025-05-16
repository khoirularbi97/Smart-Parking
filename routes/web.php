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
use App\Models\Member;
use App\Models\ParkirMasuk;
use App\Models\Transaksi;

Route::get('/auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate([
        'email' => $googleUser->getEmail(),
    ], [
        'name' => $googleUser->getName(),
        'google_id' => $googleUser->getId(),
        'avatar' => $googleUser->getAvatar(),
        'password' => bcrypt(Str::random(24)), // Optional, bisa random password
    ]);

    Auth::login($user);

    return redirect('/dashboard');

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
    Route::get('user/notfound', [UserController::class, 'index'])->name('user.notfound');
});
Route::middleware('auth','admin')->group(function () {
    Route::get('/admin/member/{user}/edit', [MemberController::class, 'edit'])->name('admin.member.edit');
    Route::put('/admin/member/{user}', [MemberController::class, 'update'])->name('admin.member.update');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('store', [MemberController::class, 'store'])->name('store');
    Route::get('/member', [MemberController::class, 'index'])->name('admin.member');
    Route::get('admin/member/create', [MemberController::class, 'create'])->name('admin/member/create');
    Route::delete('/admin/member/{id}', [MemberController::class, 'destroy'])->name('admin.member.destroy');
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');
    Route::get('admin/transaksi/create', [TransaksiController::class, 'create'])->name('admin/transaksi/create');
    Route::get('/admin/transaksi/{user}/edit', [TransaksiController::class, 'edit'])->name('admin.transaksi.edit');
    Route::post('store/transaksi', [TransaksiController::class, 'store'])->name('store.transaksi');
    Route::put('/admin/transaksi/{user}', [TransaksiController::class, 'update'])->name('admin.transaksi.update');
    Route::delete('/admin/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('admin.transaksi.destroy');
    Route::get('/parkir_masuk', [ParkirMasukController::class, 'index'])->name('parkir.masuk');
    Route::delete('admin/parkir_masuk/{id}', [ParkirMasukController::class, 'destroy'])->name('admin.parkir_masuk.destroy');
   
});






require __DIR__.'/auth.php';
