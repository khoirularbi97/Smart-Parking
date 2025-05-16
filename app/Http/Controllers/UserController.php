<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     public function index()
     {
    // { $user = \Auth::user();
    
    // if (!$user) {
    //     return redirect()->route('login');
    // }
    // $transaksis = $user->transaksis()->latest()->take(5)->get(); // Ambil 5 transaksi terbaru

    return view('user.notfound');
       
    }
}
