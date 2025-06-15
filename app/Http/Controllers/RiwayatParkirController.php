<?php

namespace App\Http\Controllers;

use App\Models\RiwayatParkir;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class RiwayatParkirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $query = RiwayatParkir::query(); // tanpa with('roles')
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('uid', 'like', "%$search%")
              ->orWhere('nama', 'like', "%$search%")
              ->orWhere('jenis', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%")
              ->orWhere('keterangan', 'like', "%$search%");
        });
    } elseif ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }
    $riwayat_parkir = $query->latest()->paginate(10)->withQueryString();


   

   

    return view('admin.riwayat-parkir.index', compact('riwayat_parkir'));

}
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
