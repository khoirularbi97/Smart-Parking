<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $uid = $request->input('uid');  // User ID
        $amount = 5000;  // Tarif parkir tetap

        // Cek saldo pengguna
        $user = User::find($uid);
        if (!$user) {
            return response()->json(['status' => 'failed', 'message' => 'User not found']);
        }

        if ($user->balance >= $amount) {
            // Kurangi saldo
            $user->decrement('balance', $amount);

            // Simpan transaksi
            Transaction::create([
                'user_id' => $uid,
                'amount' => $amount,
                'status' => 'success'
            ]);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Insufficient balance']);
    }
}
