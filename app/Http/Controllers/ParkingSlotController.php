<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSlot;
use App\Models\RiwayatParkir;

class ParkingSlotController extends Controller
{ public function index()
     {
   $slots = ParkingSlot::all();
    return view('admin.parking_slot.index', compact('slots'));
       
    }
}
