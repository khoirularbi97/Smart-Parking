<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Topup;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
   
   public function notificationHandler(Request $request)
{
    try {
        Log::info('Incoming Midtrans Notification', $request->all());
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;


        $notif = new Notification(); // pastikan ini bukan null

        Log::info('Parsed Notification:', [
            'transaction_status' => $notif->transaction_status,
            'order_id' => $notif->order_id,
            'fraud_status' => $notif->fraud_status,
        ]);

        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status ?? null;

        $topup = Topup::where('order_id', $orderId)->first();

        if (!$topup) {
            Log::warning("Topup not found for order_id: $orderId");
            return response()->json(['message' => 'Topup not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $topup->status = 'challenge';
            } else {

                $topup->status = 'success';
                $topup->user->increment('saldo', $topup->amount);
            }
        } elseif ($transaction == 'settlement') {
            $topup->status = 'success';
            $topup->user->increment('saldo', $topup->amount);
        } elseif ($transaction == 'pending') {
            $topup->status = 'pending';
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $topup->status = $transaction;
        }

        $topup->save();

        return response()->json(['message' => 'Notification processed']);
    } catch (\Exception $e) {
        Log::error('Midtrans Notification Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }

}
}


