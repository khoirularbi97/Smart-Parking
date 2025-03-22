<?php

namespace App\Http\Controllers;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $debit = Pembayaran::where('status', 'lunas')->sum('total_bayar');
        $kredit = Pembayaran::where('status', 'gagal')->sum('total_bayar');

        return view('dashboard', compact('debit', 'kredit'));
}
}