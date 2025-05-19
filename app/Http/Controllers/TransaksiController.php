<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{        public function index(Request $request) {
    $query = Transaksi::query(); // tanpa with('roles')
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('user_id', 'like', "%$search%")
              ->orWhere('uid', 'like', "%$search%")
              ->orWhere('nama', 'like', "%$search%")
              ->orWhere('jenis', 'like', "%$search%")
              ->orWhere('jumlah', 'like', "%$search%");
        });
    }

    $transaksis = $query->paginate(5)->withQueryString();

    $debitCount = Transaksi::where('jenis', 'debit')->count();
    $kreditCount = Transaksi::where('jenis', 'kredit')->count();

    $transaksiPerHari = DB::table('transaksis')
    ->select(
        DB::raw('DATE(created_at) as tanggal'),
        DB::raw("SUM(CASE WHEN jenis = 'debit' THEN 1 ELSE 0 END) as total_debit"),
        DB::raw("SUM(CASE WHEN jenis = 'kredit' THEN 1 ELSE 0 END) as total_kredit")
    )
    ->groupBy(DB::raw('DATE(created_at)'))
    ->orderBy('tanggal', 'ASC')
    ->get();
    return view('admin.transaksi.index', compact('transaksis','transaksiPerHari', 'debitCount', 'kreditCount'));

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
    if ($transaksi->jenis == 'kredit') {
        $oldUser->saldo -= $transaksi->jumlah;
    } else {
        $oldUser->saldo += $transaksi->jumlah;
    }

    // Step 2: Terapkan transaksi baru ke user baru
    if ($request->jenis == 'kredit') {
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
            'jumlah' => 'required|numeric'
        ]);
        \App\Models\Transaksi::create([
            'users_id' => $request->users_id,
            'uid' => $request->uid,
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'CreatedBy' => $user ? $user->name : 'system',
            'CompanyCode' => 'TR01',
            'Status' => 0 , 
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
}
