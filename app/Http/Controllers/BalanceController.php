<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Midtrans\Snap;
use Midtrans\Config;

class BalanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('balance.index', compact('user'));
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer|min:10000',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // Set your Merchant Server Key
        Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default: true)
        Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default: true)
        Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true (default: false)
        Config::$is3ds = config('midtrans.is3ds');

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'user_subscription_id' => null, // This transaction is for top-up, not subscription
            'price' => $amount,
            'title' => 'Top Up Saldo',
            'quantity' => 1,
            'total' => $amount,
            'payment_status' => 1, // PENDING
            'snap_token' => null,
            'expired_at' => null,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->nama_lengkap,
                'email' => $user->email,
                'phone' => $user->telp ?? '081234567890', // Use a default phone if not available
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $transaction->snap_token = $snapToken;
            $transaction->save();

            return redirect()->away($snapToken); // Redirect to Midtrans payment page
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }
}
