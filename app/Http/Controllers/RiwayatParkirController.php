<?php

namespace App\Http\Controllers;

use App\Models\RiwayatParkir;
use App\Models\Transaksi;
use App\Models\User;

use Illuminate\Support\Facades\DB;
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
         $query = RiwayatParkir::query()->with(['user', 'parking_slot']);

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

     // Ambil data untuk chart (7 hari terakhir)
    $chartData = RiwayatParkir::select(
        DB::raw("DATE(created_at) as date"),
        DB::raw("SUM(biaya) as total")
    )
    ->when($request->filled('start_date') && $request->filled('end_date'), function ($q) use ($request) {
        $q->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    })
    ->groupBy('date')
    ->orderBy('date')
    ->get();

    // Siapkan data untuk chart.js
    $dates = $chartData->pluck('date');
    $totals = $chartData->pluck('total');



   

   

    return view('admin.riwayat-parkir.index', compact('riwayat_parkir', 'dates', 'totals'));

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
    {$riwayat_parkir = RiwayatParkir::findOrFail($id);
    $user = $riwayat_parkir->name;

    
    $riwayat_parkir->delete();

        return redirect()
    ->route('riwayat.parkir')
    ->with('success', "Riwayat ($user) berhasil dihapus.");

    }
}
