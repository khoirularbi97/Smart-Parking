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
    public function index(Request $request)
    {

        $debitCount = Transaksi::where('jenis', 'debit')->count();
        $kreditCount = Transaksi::where('jenis', 'kredit')->count();

        $range_topup = $request->input('range_topup');
        $range_riwayat_topup = $request->input('range_riwayat_topup');
        $range_laba = $request->input('range_laba');
        $range_parkir = $request->input('range_parkir');
        $range_transaksi = $request->input('range_transaksi');


        $transaksiPerHari = DB::table('transaksis')
        ->select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw("SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) as total_debit"),
            DB::raw("SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END) as total_kredit")
        )->when($range_transaksi == '7', function ($query) {
                return $query->where('created_at', '>=', now()->subDays(7));
            })
            ->when($range_transaksi == '30', function ($query) {
                return $query->where('created_at', '>=', now()->subDays(30));
            })
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('tanggal', 'ASC')
        ->get();
        
       
        $member = User::where('role', 'user')->count();
        $admin = User::where('role', 'admin')->count();
        
       
        
         $histories = DB::table('topups')
         ->when($range_riwayat_topup == '7', function ($query) {
        return $query->where('topups.created_at', '>=', now()->subDays(7));
        })
        ->when($range_riwayat_topup == '30', function ($query) {
            return $query->where('topups.created_at', '>=', now()->subDays(30));
        })
        ->join('users', 'topups.users_id', '=', 'users.id')
        ->select('topups.*', 'users.name as user_name')
        ->orderByDesc('topups.created_at')
        ->paginate(5); // <= pagination di sini

        $chartQuery = RiwayatParkir::select(
        DB::raw("DATE(created_at) as date"),
        DB::raw("SUM(biaya) as total_biaya"),
        DB::raw("COUNT(*) as total_kendaraan"))
        ->when($range_parkir == '7', function ($query) {
        return $query->where('created_at', '>=', now()->subDays(7));
        })
        ->when($range_parkir == '30', function ($query) {
            return $query->where('created_at', '>=', now()->subDays(30));
        })
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


        $data = DB::table('transaksis')
        ->select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw("SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END) as total_kredit"),
            DB::raw("SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) as total_debit")
        )
        ->when($range_laba == '7', function ($query) {
            return $query->where('created_at', '>=', now()->subDays(7));
        })
        ->when($range_laba == '30', function ($query) {
            return $query->where('created_at', '>=', now()->subDays(30));
        })
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

    $labels = [];
    $keuntungan = [];

    $methodData = \App\Models\Topup::selectRaw('method, COUNT(*) as total')
    ->when($range_topup == '7', function ($query) {
        return $query->where('created_at', '>=', now()->subDays(7));
    })
    ->when($range_topup == '30', function ($query) {
        return $query->where('created_at', '>=', now()->subDays(30));
    })
    ->groupBy('method')
    ->pluck('total', 'method');

    $methodLabels = $methodData->keys();
    $methodCounts = $methodData->values();

    foreach ($data as $item) {
        $item->laba = $item->total_kredit - $item->total_debit;
    }

        return view('dashboard', compact( 'data', 'methodLabels', 'methodCounts', 'totalTerparkir', 'totalMasukHariIni', 'totalKeluarHariIni', 'member', 'dates', 'totals', 'admin', 'total_kendaraan', 'transaksiPerHari', 'debitCount', 'kreditCount', 'histories'));
}
}