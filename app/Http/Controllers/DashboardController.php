<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use App\Models\Member;
use App\Models\ParkirMasuk;
use App\Models\Transaksi;
use App\Models\RiwayatParkir;

use App\Models\User;
use App\Models\Topup;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $debitCount = Transaksi::where('jenis', 'debit')->count();
        $kreditCount = Transaksi::where('jenis', 'kredit')->count();

        $transaksiPerHari = DB::table('transaksis')
        ->select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw("SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) as total_debit"),
            DB::raw("SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END) as total_kredit")
        )
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('tanggal', 'ASC')
        ->get();
        
       
        $member = User::where('role', 'user')->count();
        $admin = User::where('role', 'admin')->count();
        
       
        
         $histories = DB::table('topups')
        ->join('users', 'topups.users_id', '=', 'users.id')
        ->select('topups.*', 'users.name as user_name')
        ->orderByDesc('topups.created_at')
        ->paginate(5); // <= pagination di sini

        $chartQuery = RiwayatParkir::select(
        DB::raw("DATE(created_at) as date"),
        DB::raw("SUM(biaya) as total_biaya"),
        DB::raw("COUNT(*) as total_kendaraan"))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // SIAPKAN DATA UNTUK CHART.JS
            $dates = $chartQuery->pluck('date');
            $totals = $chartQuery->pluck('total_biaya');
            $total_kendaraan = $chartQuery->pluck('total_kendaraan');

        $today = now()->format('Y-m-d');

            // Jumlah kendaraan masih terparkir (belum keluar)
            $totalTerparkir = ParkirMasuk::where('status', 'aktif')->count();

            // Jumlah kendaraan masuk hari ini
            $totalMasukHariIni = RiwayatParkir::whereDate('waktu_masuk', $today)->count();

            // Jumlah kendaraan keluar hari ini
            $totalKeluarHariIni = RiwayatParkir::whereDate('waktu_keluar', $today)->count();

        return view('dashboard', compact( 'totalTerparkir', 'totalMasukHariIni', 'totalKeluarHariIni', 'member', 'dates', 'totals','admin', 'total_kendaraan', 'transaksiPerHari', 'debitCount', 'kreditCount', 'histories'));
}
}