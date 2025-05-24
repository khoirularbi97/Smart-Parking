<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Topup;
use Midtrans\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
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
            'user_id' => $user->id,
            'amount' => $amount,
            'status' => 'pending',
            'order_id' =>$orderId,
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

        public function callback(Request $request)
        {
            
        // Ambil notifikasi pembayaran dari Midtrans
        $notif = new Notification();
        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status ?? null;

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
           

}
