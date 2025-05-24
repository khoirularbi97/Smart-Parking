<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Topup;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TopupController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.sanitized');
        Config::$is3ds = config('midtrans.3ds');
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
        $notif = new \Midtrans\Notification();
        $topup = Topup::where('order_id', $notif->order_id)->first();

        if ($notif->transaction_status == 'capture') {
            $topup->status = 'success';
            $topup->save();

            // Tambah saldo user
            $topup->user->increment('saldo', $topup->amount);

        } else if ($notif->transaction_status == 'expire' || $notif->transaction_status == 'cancel') {
            $topup->status = 'failed';
            $topup->save();
        }

        return response()->json(['message' => 'Callback received']);
    }
}
