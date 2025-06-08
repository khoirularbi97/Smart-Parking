<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;
use App\Models\Transaksi;
use App\Models\User;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TopupAdminController extends Controller
{
    public function index(Request $request) {
    $query = Topup::query(); // tanpa with('roles')
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('users_id', 'like', "%$search%")
              ->orWhere('name', 'like', "%$search%")
              ->orWhere('order_id', 'like', "%$search%")
              ->orWhere('method', 'like', "%$search%")
              ->orWhere('amount', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhere('created_at', 'like', "%$search%");
        });
    }

    $topup= $query->latest()->paginate(10)->withQueryString();

    
    
    return view('admin.topup.index', compact('topup'));

    }
     public function create()
    {
         $users = User::where('role', 'user')->select('id as users_id', 'alamat', 'name')->get(); 
        return view('admin.topup.create-topup', compact('users'));
    }
    public function __construct()
    {
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');
    }

    public function process(Request $request)
    {
        $user =User::findOrFail($request->users_id);
        $amount = $request->amount;
        $orderId = 'TOPUP-' . time() . '-' . Str::random(5); // contoh format order_id unik
        // Simpan ke DB dulu (optional, untuk callback tracking)
        
        $topup = Topup::create([
            'users_id' => $user->id,
            'name'   => $user->name,
            'alamat'   => $user->alamat,
            'method'   => 'waiting',
            'amount' => $amount,
            'status' => 'pending',
            'order_id' =>$orderId,
            
        ]);
        $transaksi = Transaksi::create([
            'users_id' => $user->id,
            'nama'   => $user->name,
            'uid'   => $user->uid,
            'jenis'   => 'debit',
            'jumlah' => $amount,
            'Status' => 1,
            
            
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $topup->order_id,
                'gross_amount' => (int) $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

       
                return response()->json([
            'message' => 'Testing Midtrans',
            'token' => $snapToken
        ]);

    }
}
