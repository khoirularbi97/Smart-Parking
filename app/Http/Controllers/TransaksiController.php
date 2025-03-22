<?php
namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('user')->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.transaksi.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:kredit,debit',
            'jumlah' => 'required|numeric'
        ]);

        $transaksi = Transaksi::create($request->all());

        // Update saldo
        $user = User::find($request->user_id);
        if ($request->jenis == 'kredit') {
            $user->saldo += $request->jumlah;
        } else {
            $user->saldo -= $request->jumlah;
        }
        $user->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $user = User::find($transaksi->user_id);
        if ($transaksi->jenis == 'kredit') {
            $user->saldo -= $transaksi->jumlah;
        } else {
            $user->saldo += $transaksi->jumlah;
        }
        $user->save();

        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
