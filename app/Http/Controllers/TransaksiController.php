<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    return view('admin.transaksi.index', compact('transaksis'));

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
            'IsDeleted' => 1,

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
