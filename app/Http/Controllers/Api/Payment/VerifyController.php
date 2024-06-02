<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\Services\WalletService;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verifyTransaction(Request $request)
    {
        if ($request->status == 0) {
            $transaction = Transaction::where('order_id', $request->OrderId)->first();
            $payment = PaymentService::verifyPayment($request->Token, $transaction);
            
            if ($transaction->type == 'donate') {
                WalletService::chargeWallet($transaction->streamer, $transaction->amount);
            } else if ($transaction->type == 'charge') {
                WalletService::chargeWallet($transaction->user, $transaction->amount);
            } else if ($transaction->type == 'subscription') {
                echo 'subscribed';
            }

            dd($payment);
        }

        
        return 'error';
    }
}
