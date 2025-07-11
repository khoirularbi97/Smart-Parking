<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransaksiController extends Controller
{        public function index(Request $request) {
    $query = Transaksi::query(); // tanpa with('roles')
    
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
    $transaksis = $query->latest()->paginate(10)->withQueryString();


   // Ambil data untuk chart (7 hari terakhir)
    $chartData = Transaksi::select(
        DB::raw("DATE(created_at) as date"),
        DB::raw("SUM(jumlah) as total")
    )
     ->when($request->filled('search'), function ($query) use ($request) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('uid', 'like', "%$search%")
              ->orWhere('nama', 'like', "%$search%")
              ->orWhere('jenis', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%")
              ->orWhere('keterangan', 'like', "%$search%");
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

    // Siapkan data untuk chart.js
    $dates = $chartData->pluck('date');
    $totals = $chartData->pluck('total');

    $debitCount = Transaksi::where('jenis', 'debit')
     ->when($request->filled('search'), function ($query) use ($request) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('uid', 'like', "%$search%")
              ->orWhere('nama', 'like', "%$search%")
              ->orWhere('jenis', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%")
              ->orWhere('keterangan', 'like', "%$search%");
        });
    })
    ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    })->count();
    $kreditCount = Transaksi::where('jenis', 'kredit')
     ->when($request->filled('search'), function ($query) use ($request) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('uid', 'like', "%$search%")
              ->orWhere('nama', 'like', "%$search%")
              ->orWhere('jenis', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%")
              ->orWhere('keterangan', 'like', "%$search%");
        });
    })
    ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    })->count();

    return view('admin.transaksi.index', compact('transaksis', 'debitCount', 'kreditCount', 'dates', 'totals'));

}
    public function edit($id)
    {
    $transaksi = Transaksi::findOrFail($id);
    $users = User::where('role', 'user')->select('id as users_id', 'uid', 'name')->get(); 
    return view('admin.transaksi.edit')
            ->with('transaksi', $transaksi)
            ->with('users', $users);
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'jenis' => 'required|string|max:255',
        'users_id' => 'required|string|max:255',
        'uid' => 'required|string|max:255',
        'jumlah' => 'required|numeric',
        'keterangan' => 'required|string',
    ]);
    
    $userUpdated = Auth::user();
    $transaksi = Transaksi::findOrFail($id);

    $oldUser = User::findOrFail($transaksi->users_id);
    $newUser = User::findOrFail($request->users_id);

    if ($transaksi->users_id == $request->users_id){

        $user = User::findOrFail($transaksi->users_id); // Ambil user terkait
        // Hitung ulang saldo: kembalikan dulu saldo lama
        if ($transaksi->jenis == 'kredit') {
            $user->saldo -= $transaksi->jumlah;
        } else {
            $user->saldo += $transaksi->jumlah;
        }
    
        // Terapkan saldo baru dari input
        if ($request->jenis == 'kredit') {
            $user->saldo += $request->jumlah;
        } else {
            $user->saldo -= $request->jumlah;
        }
    
        $user->save(); // Simpan saldo baru
    }else{
    // Step 1: Kembalikan saldo user lama berdasarkan transaksi sebelumnya
    if ($transaksi->jenis == 'debit') {
        $oldUser->saldo -= $transaksi->jumlah;
    } else {
        $oldUser->saldo += $transaksi->jumlah;
    }

    // Step 2: Terapkan transaksi baru ke user baru
    if ($request->jenis == 'debit') {
        $newUser->saldo += $request->jumlah;
    } else { // debit
        $newUser->saldo -= $request->jumlah;
    }

    $oldUser->save();
    $newUser->save();
    
    
        
    }

    $user3 = $transaksi->nama;
    $transaksi->nama = $request->nama;
    $transaksi->jenis = $request->jenis;
    $transaksi->uid = $request->uid;
    $transaksi->jumlah = $request->jumlah;
    $transaksi->LastUpdateBy = $userUpdated ? $userUpdated->name : 'system';
    $transaksi->Status = 1;
    $transaksi->IsDeleted = 1;
    $transaksi->LastUpdateDate = now();

    $transaksi->save();
    if (!$user3) {
        return redirect()->route('transaksi')->with('error', 'User tidak ditemukan.');
    }
        
    return redirect()->route('transaksi')->with('success', 'Data transaksi (' . $user3 . ' ) berhasil diperbarui!');
    

}

    public function create()
    {
         $users = User::where('role', 'user')->select('id as users_id', 'uid', 'name')->get(); 
        return view('admin.transaksi.create', compact('users'));
    }

    public function store(Request $request)
    {
    
         $user = Auth::user();
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'uid' => 'required|string',
            'nama' => 'required|string',
            'jenis' => 'required|in:kredit,debit',
            'jumlah' => 'required|numeric',
            'keterangan' => 'required|string'
        ]);
        \App\Models\Transaksi::create([
            'users_id' => $request->users_id,
            'uid' => $request->uid,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'CreatedBy' => $user ? $user->name : 'system',
            'CompanyCode' => 'TR01',
            'Status' => 1 , 
            'IsDeleted' => 0,

        ]);
        // Update saldo
        $user1 = User::find($request->users_id);
        if ($request->jenis == 'kredit') {
            $user1->saldo += $request->jumlah;
        } else {
            $user1->saldo -= $request->jumlah;
        }
       
        $user1->save();
     
        return redirect()->route('transaksi')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function destroy($id)
     {
    $transaksi = Transaksi::findOrFail($id);
    $user = User::find($transaksi->users_id);

    if (!$user) {
        return redirect()->route('transaksi')
            ->with('error', 'User tidak ditemukan. Gagal menghapus transaksi.');
    }

    if ($transaksi->jenis == 'kredit') {
        $user->saldo -= $transaksi->jumlah;
    } else {
        $user->saldo += $transaksi->jumlah;
    }
    $user1 =$user->name;
    $user->save();
    $transaksi->delete();

        return redirect()->route('transaksi')->with('success', 'Transaksi (' . $user1 . ' ) berhasil dihapus.');
    }
    public function exportPdf(Request $request)
{
    $query = Transaksi::query();

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }elseif ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('uid', 'like', "%$search%")
              ->orWhere('nama', 'like', "%$search%")
              ->orWhere('jenis', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%")
              ->orWhere('keterangan', 'like', "%$search%");
        });
    }

    $transaksis = $query->latest()->get();

    $pdf = Pdf::loadView('admin.transaksi.print.table-pdf', compact('transaksis'));
    return $pdf->download('laporan-transaksi.pdf');
}
public function exportPDF2(Request $request)
{
    $base64Image = $request->input('chart_image');
    $base64ImageDonat = $request->input('chart_image_donat');

   $query = Transaksi::query();

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }elseif ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('uid', 'like', "%$search%")
              ->orWhere('nama', 'like', "%$search%")
              ->orWhere('jenis', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%")
              ->orWhere('keterangan', 'like', "%$search%");
        });
    }

    $transaksis = $query->latest()->orderBy('created_at')->get();
   

    $pdf = Pdf::loadView('admin.transaksi.print.pdf', [
         'chartBase64' => $base64Image, // Kirim ke Blade
         'chartBase64Donat' => $base64ImageDonat, // Kirim ke Blade
    ],compact('transaksis'));

    
    return $pdf->download('laporan_transaksi.pdf');
}
public function chartKeuntunganBulanan()
{
    $data = DB::table('transaksis')
        ->select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw("SUM(CASE WHEN jenis = 'kredit' THEN jumlah ELSE 0 END) as total_kredit"),
            DB::raw("SUM(CASE WHEN jenis = 'debit' THEN jumlah ELSE 0 END) as total_debit")
        )
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

    $labels = [];
    $keuntungan = [];

    foreach ($data as $item) {
        $item->laba = $item->total_kredit - $item->total_debit;
    }

    return view('admin.laporan.chart_keuntungan', compact('data'));
}
public function export(Request $request)
{
    $chartBase64 = $request->chart; // data:image/png;base64,xxx
  // Ambil data laporan dari request POST
    $laporanDataEncoded = $request->laporan_data;
    $data = json_decode(base64_decode($laporanDataEncoded), true); // decode menjadi array


    $pdf = Pdf::loadView('admin.laporan.pdf', compact('chartBase64', 'data'))->setPaper('a4', 'portrait');
    return $pdf->download('laporan_keuntungan.pdf');
}
}
