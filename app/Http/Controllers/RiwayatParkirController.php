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
            $q->where('uid', 'like', "%$search%")
              ->orWhere('_Status', 'like', "%$search%")
              ->orWhere('biaya', 'like', "%$search%")
              ->orWhere('durasi', 'like', "%$search%")
              ->orWhereHas('user', function($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%");
              });
        });
    } elseif ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }

    $riwayat_parkir = $query->latest()->paginate(10)->withQueryString();

    // CHART: TOTAL BIAYA & JUMLAH KENDARAAN PER HARI
    $chartData = RiwayatParkir::select(
        DB::raw("DATE(created_at) as date"),
        DB::raw("SUM(biaya) as total_biaya"),
        DB::raw("COUNT(*) as total_kendaraan")

    ) 
    ->when($request->filled('search'), function ($query) use ($request) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
           $q->where('uid', 'like', "%$search%")
              ->orWhere('_Status', 'like', "%$search%")
              ->orWhere('biaya', 'like', "%$search%")
              ->orWhere('durasi', 'like', "%$search%")
              ->orWhereHas('user', function($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%");
              });      
        });
    })
    ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    })
    ->groupBy('date')
    ->orderBy('date')
    ->get();

    
    

    

    // SIAPKAN DATA UNTUK CHART.JS
    $dates = $chartData->pluck('date');
    $totals = $chartData->pluck('total_biaya');
    $total_kendaraan = $chartData->pluck('total_kendaraan');
   

   

     return view('admin.riwayat-parkir.index', compact('riwayat_parkir', 'dates', 'totals', 'total_kendaraan'));

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
    $oldUser = User::find($riwayat_parkir->users_id);
    $oldName = $oldUser->name;

    
    $riwayat_parkir->delete();

        return redirect()
    ->route('riwayat.parkir')
    ->with('success', "Riwayat ($oldName) berhasil dihapus.");

    }

    public function exportPDF2(Request $request)
{
    $base64Image = $request->input('chart_image');
    

   $query = RiwayatParkir::query();

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }elseif ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('uid', 'like', "%$search%")
              ->orWhere('_Status', 'like', "%$search%")
              ->orWhere('biaya', 'like', "%$search%")
              ->orWhere('durasi', 'like', "%$search%")
              ->orWhereHas('user', function($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%");
              });
        });
    }

    $riwayat_parkir = $query->latest()->orderBy('created_at')->get();
   

    $pdf = Pdf::loadView('admin.riwayat-parkir.pdf', [
         'chartBase64' => $base64Image // Kirim ke Blade
    ],compact('riwayat_parkir'));

    
    return $pdf->download('laporan_riwayat_parkir.pdf');
    }
}
