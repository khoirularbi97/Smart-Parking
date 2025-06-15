<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;
use App\Models\Transaksi;
use App\Models\User;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
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
    } elseif ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }

    $topup= $query->latest()->paginate(10)->withQueryString();
    // Ambil data untuk chart (7 hari terakhir)
    $chartData = Topup::select(
        DB::raw("DATE(created_at) as date"),
        DB::raw("SUM(amount) as total")
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


    
    
    return view('admin.topup.index', compact('topup', 'dates', 'totals'));

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
        $user_auth = Auth::user();
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
            'CreatedBy' =>$user_auth ? $user_auth->name : 'system',
            'CompanyCode' => 'TR01',
            'IsDeleted' => 0,
            
        ]);
        $transaksi = Transaksi::create([
            'users_id' => $user->id,
            'nama'   => $user->name,
            'uid'   => $user->uid,
            'jenis'   => 'debit',
            'jumlah' => $amount,
            'keterangan' => 'topup',
            'order_id' => $orderId,
            'Status' => 0,
            'CreatedBy' =>$user_auth ? $user_auth->name : 'system',
            'CompanyCode' => 'TR01',
            'IsDeleted' => 0,
            
            
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
