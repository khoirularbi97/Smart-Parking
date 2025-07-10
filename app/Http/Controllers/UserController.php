<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParkingSlot;
use App\Models\User;
use App\Models\RiwayatParkir;


class UserController extends Controller
{
     public function index()
     {
    $user =Auth::user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    $histories = $user->parking()->latest()->paginate(5); // Ambil 5 transaksi terbaru
    $isAktiv= $user->masuk()->latest()->paginate(5); // Ambil 5 transaksi terbaru
    $slots = ParkingSlot::all();
    return view('user.dashboard', compact('histories', 'slots', 'isAktiv'));
       
    }

}
