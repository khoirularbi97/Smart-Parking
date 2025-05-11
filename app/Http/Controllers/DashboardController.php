<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use App\Models\Member;
use App\Models\Transaksi;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $debit = Transaksi::where('jenis', 'debit')->count();
        $kredit = Transaksi::where('jenis', 'kredit')->count();
        
       
        $member = User::where('role', 'user')->count();
        $admin = User::where('role', 'admin')->count();
        
        $total = User::where('role', 'user')->paginate(5);

        return view('dashboard', compact('debit', 'kredit','member', 'total','admin'));
}
}