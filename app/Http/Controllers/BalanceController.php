<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

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

        $user->reward_balance += $amount;
        $user->save();

        // Create a transaction record for the top-up
        Transaction::create([
            'user_id' => $user->id,
            'user_subscription_id' => null, // This transaction is for top-up, not subscription
            'price' => $amount,
            'title' => 'Top Up Saldo',
            'quantity' => 1,
            'total' => $amount,
            'payment_status' => 2, // SUCCESS
            'snap_token' => null,
            'expired_at' => null,
        ]);

        return redirect()->back()->with('success', 'Top Up Saldo sebesar Rp' . number_format($amount, 0, ',', '.') . ' berhasil!');
    }
}
