<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use App\Models\Member;
use App\Models\Transaksi;

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
        ->paginate(3); // <= pagination di sini

        return view('dashboard', compact('member','admin', 'transaksiPerHari', 'debitCount', 'kreditCount', 'histories'));
}
}