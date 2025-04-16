<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use App\Models\Member;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $debit = Pembayaran::where('status', 'debit')->count();
        $kredit = Pembayaran::where('status', 'kredit')->count();
        
        $member = Member::orderBy('id','desc')->get();
        $total = Member::count();
        $admin = User::count();

        return view('dashboard', compact('debit', 'kredit','member', 'total','admin'));
}
}