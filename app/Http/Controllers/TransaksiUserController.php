<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiUserController extends Controller
{
    public function index()
{
    $histories = auth()->user()->transaksis()->orderBy('created_at', 'desc')->paginate(5);
    return view('user.transaksi.index', compact('histories'));
}

}
