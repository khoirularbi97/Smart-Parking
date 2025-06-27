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
    public function store(Request $request)
{
    $request->validate([
        'kode_slot' => 'required|unique:parking_slots,id',
        'status' => 'required|in:tersedia,terisi'
    ]);

    ParkingSlot::create([
        'name' => $request->kode_slot,
        'is_available' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Slot parkir berhasil ditambahkan.');
}
public function update(Request $request, $id)
{
    $request->validate([
        'kode_slot' => 'required',
        'status' => 'required|in:tersedia,terisi',
    ]);

    $slot = ParkingSlot::findOrFail($id);
    $slot->update([
        'name' => $request->kode_slot,
        'is_available' => $request->status,
    ]);

    return redirect()->back()->with('success', 'Slot parkir berhasil diperbarui.');
}


}
