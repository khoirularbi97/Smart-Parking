<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Topup;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
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
