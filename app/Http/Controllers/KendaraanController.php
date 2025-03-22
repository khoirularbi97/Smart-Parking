<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
 


    public function index()
    {
        $kendaraan = Kendaraan::all(); // Ambil semua data
        return view('dashboard', compact('kendaraan'));

        return Kendaraan::with('user')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'plat_nomor' => 'required|string|unique:kendaraans,plat_nomor',
            'tipe_kendaraan' => 'required|in:mobil,motor'
        ]);

        return Kendaraan::create($request->all());
    }

    public function show($id)
    {
        return Kendaraan::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->update($request->all());

        return $kendaraan;
    }

    public function destroy($id)
    {
        return Kendaraan::destroy($id);
    }
}
