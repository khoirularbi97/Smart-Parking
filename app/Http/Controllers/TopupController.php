<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Topup;
use App\Models\Transaksi;
use Midtrans\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\ParkingSlot;


class TopupController extends Controller
{   
     public function index()
     {
    $user =Auth::user();
    
    if (!$user) {
        return redirect()->route('login');
    }
    $histories = $user->topup()->latest()->take(5)->get(); // Ambil 5 transaksi terbaru
    $slots = Topup::all();
    return view('user.topup.form', compact('histories', 'slots'));
       
    
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
        $user = Auth::user();
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
            'CreatedBy' =>$user ? $user->name : 'system',
            'CompanyCode' => 'TU01',
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
            'CreatedBy' =>$user ? $user->name : 'system',
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
            'token' => $snapToken,
            'order_id' => $orderId
        ]);

    }

        public function callback(Request $request)
        {
            
        // Ambil notifikasi pembayaran dari Midtrans
        $notif = new Notification();
        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status ?? null;
        $user = Auth::user();
        $topup = Topup::where('order_id', $orderId)->first();

        if (!$topup) {
            return response()->json(['message' => 'Topup not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $topup->status = 'challenge';
            } else {
                $topup->status = 'success';
                $topup->user->increment('balance', $topup->amount);
                
            }
        } elseif ($transaction == 'settlement') {
            $topup->status = 'success';
            $topup->user->increment('balance', $topup->amount);
        } elseif ($transaction == 'pending') {
            $topup->status = 'pending';
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $topup->status = $transaction;
        }

        $topup->save();

        return response()->json(['message' => 'Notification processed']);
    }

    public function showInvoice($order_id, Request $request)

{   

     if ($request->status === 'success') {
        session()->flash('success', 'Pembayaran berhasil.');
    }elseif ($request->status === 'waiting'){
        session()->flash('info', 'Menunggu pembayaran.');
    }else{
        session()->flash('error', 'Pembayaran gagal!');
    }
    $invoice = Topup::where('order_id', $order_id)->firstOrFail();
    return view('user.topup.invoice', compact('invoice'));
}
           

}
