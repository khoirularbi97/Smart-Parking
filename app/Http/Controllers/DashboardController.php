<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use App\Models\Member;
use App\Models\Transaksi;
use App\Models\User;
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
            DB::raw("SUM(CASE WHEN jenis = 'debit' THEN 1 ELSE 0 END) as total_debit"),
            DB::raw("SUM(CASE WHEN jenis = 'kredit' THEN 1 ELSE 0 END) as total_kredit")
        )
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('tanggal', 'ASC')
        ->get();
        
       
        $member = User::where('role', 'user')->count();
        $admin = User::where('role', 'admin')->count();
        
        $total = User::where('role', 'user')->paginate(3);

        return view('dashboard', compact('member', 'total','admin', 'transaksiPerHari', 'debitCount', 'kreditCount'));
}
}