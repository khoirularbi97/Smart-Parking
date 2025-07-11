<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParkingSlot;
use App\Models\User;
use App\Models\RiwayatParkir;

class ParkingSlotController extends Controller
{ public function index()
     {
      $slots = ParkingSlot::with('user')->get(); 
      $users = User::all();
    return view('admin.parking_slot.index', compact('slots', 'users'));
       
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'kode_slot' => 'required|string|max:10|unique:parking_slots,name',
        'status' => 'required|in:tersedia,terisi',
        'users_id' => 'nullable|exists:users,id',  ], [
        'kode_slot.unique' => 'Kode slot sudah digunakan.',
    ]);
    

    // Kosongkan users_id jika status tersedia
    if ($validated['status'] === 'tersedia') {
        $validated['users_id'] = null;
    }

    ParkingSlot::create([
        'name' => $validated['kode_slot'],
        'is_available' => $validated['status'],
        'users_id' => $validated['users_id'],
    ]);

    return redirect()->back()->with('success', 'Slot parkir berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $slot = ParkingSlot::findOrFail($id);

    $validated = $request->validate([
        'kode_slot' => 'required|string|max:10|unique:parking_slots,name,' . $slot->id,
        'status' => 'required|in:tersedia,terisi',
        'users_id' => 'nullable|exists:users,id',
          ], [
        'kode_slot.unique' => 'Kode slot sudah digunakan.',
    ]);
   
    // Kosongkan users_id jika status tersedia
    if ($validated['status'] === 'tersedia') {
        $validated['users_id'] = null;
    }
    

    $slot->update([
        'name' => $validated['kode_slot'],
        'is_available' => $validated['status'],
        'users_id' => $validated['users_id'],
    ]);

    return redirect()->back()->with('success', 'Slot parkir berhasil diperbarui.');
}
     public function destroy($id)
     {
    $slot = ParkingSlot::findOrFail($id);
    $oldSlot = $slot->name;

    if (!$oldSlot) {
        return redirect()->route('parkir.slot')
            ->with('error', 'Slot tidak ditemukan. Gagal menghapus transaksi.');
    }

    
   
    $slot->delete();

        return redirect()->route('parkir.slot')->with('success', 'Slot (' . $oldSlot. ' ) berhasil dihapus.');
    }


}
