<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Topup;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;

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
        $transaksi = Transaksi::where('order_id', $orderId)->first();
      
        if (!$topup) {
            Log::warning("Topup not found for order_id: $orderId");
            return response()->json(['message' => 'Topup not found'], 404);
        }

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
                $topup->status = 'challenge';
            } else {

                $topup->status = 'success';
                $transaksi->Status = 1;
                
                if ($topup->user) {
			    $topup->user->increment('saldo', $topup->amount);
			} else {
			    Log::error("User not found for Topup ID: {$topup->id}, Order ID: {$orderId}");
			    return response()->json(['message' => 'User not found'], 404);
			}


		
		                if (isset($notif->card_type)) {
		            $cardType = $notif->card_type;
		            Log::info("Card type used: " . $cardType);
		            
			}
	$topup->method = $notif->card_type ?? null;

            }
        } elseif ($transaction == 'settlement') {
            $topup->status = 'success';
            $transaksi->Status = 1;
            if ($topup->user) {
			    $topup->user->increment('saldo', $topup->amount);
			} else {
			    Log::error("User not found for Topup ID: {$topup->id}, Order ID: {$orderId}");
			    return response()->json(['message' => 'User not found'], 404);
			}


		
        } elseif ($transaction == 'pending') {
            $topup->status = 'pending';
        } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
            $topup->status = $transaction;
        }

        $topup->save();
        $transaksi->save();

        return response()->json(['message' => 'Notification processed']);
    } catch (\Exception $e) {
        Log::error('Midtrans Notification Error: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }

}



public function checkStatus($orderId)
{
    try {
        Log::info('Cek status topup', [
            'order_id' => $orderId,
            'server_key' => config('midtrans.serverKey'),
            'env' => config('midtrans.is_Production')
        ]);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.is_Production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $status = \Midtrans\Transaction::status($orderId);
        $transaksi = Transaksi::where('order_id', $orderId)->first();
 



        Log::info('Midtrans Status Result:', (array) $status);

        
        // $url = "https://api.sandbox.midtrans.com/v2/{$orderId}/status";

        // $response = Http::withBasicAuth($serverKey, '')
        //     ->get($url);
        // Log::info('Full Midtrans Status Response:', (array) $response);


        $transactionStatus = $status->transaction_status;
        $fraudStatus = $status->fraud_status;
        if (
            $transactionStatus === 'capture' && $fraudStatus  === 'accept' ||
            $transactionStatus === 'settlement'
        ) {
            $_status = 'success';
        } else {
            $_status = 'failed';
        }
        $topup = Topup::where('order_id', $orderId)->first();
        if (!$topup) {
            Log::warning("Topup not found for order_id: $orderId");
            return response()->json(['message' => 'Topup not found'], 404);
        }
        $topup->status = $_status;
        
        // $topup->user->increment('saldo', $topup->amount);
        $topup->method = $status->payment_type;
        $topup->updated_at = now();
        if ($_status == 'success'){
            $transaksi->Status = 1;
        }else{
            $transaksi->Status = 0;
        }

        $topup->save();
        $transaksi->save();



   
        return response()->json([
            'message' => 'Status berhasil diambil',
            'status' => $_status  ?? null,
            'payment_type' => $status->payment_type ?? null,
            'transaction_time' => Carbon::parse($status->transaction_time)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
            'gross_amount' => $status->gross_amount ?? null
        ]);
            
    } catch (\Exception $e) {
        Log::error("Midtrans Status Error: " . $e->getMessage());
        return response()->json([
            'error' => 'Terjadi kesalahan server',
            'message' => $e->getMessage()
        ], 500);
    }
}
public function getStatus($orderId)
{
    try {
        Log::info('Cek status topup', [
            'order_id' => $orderId,
            'server_key' => config('midtrans.serverKey'),
            'env' => config('midtrans.is_Production')
        ]);

        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.is_Production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $status = \Midtrans\Transaction::status($orderId);

        return response()->json([
            'message' => 'Status berhasil diambil',
            'status' => $status->transaction_status ?? null,
            'payment_type' => $status->payment_type ?? null,
            'transaction_time' => Carbon::parse($status->transaction_time)->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s'),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Gagal mengambil status',
            'error' => $e->getMessage()
        ], 500);
    }
}


}


