<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Models\Kind;
use App\Models\Transaction;
use App\Models\User;
use App\Services\DonateAmountService;
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
                $streamer = $transaction->streamer;
                $amountToBeCharge = $this->calculateAmount($streamer, $transaction);
                WalletService::chargeWallet($streamer, $amountToBeCharge);
            } else if ($transaction->type == 'charge') {
                WalletService::chargeWallet($transaction->user, $transaction->raw_amount);
            } else if ($transaction->type == 'subscription') {
                $vipPackagePrice = Kind::where('key', 'vip_package_price')->first()->value_2;
                $months = $transaction->amount / $vipPackagePrice;
                $transaction->user->assignRole('vip');
            }

            dd($payment);
        }        
        return 'error';
    }

    private function calculateAmount(User $streamer, Transaction $transaction): int
    {
        $amount = $transaction->raw_amount;
        $finalAmount = $amount;
        if (!$streamer->gateway->is_donator_pay_wage && $streamer->gateway->is_donator_pay_wage != '') {
            $finalAmount -= DonateAmountService::calculateWage($streamer, $amount);
        }

        if (!$streamer->gateway->is_donator_pay_tax && $streamer->gateway->is_donator_pay_tax != '') {
            $finalAmount -= DonateAmountService::calculateTax($amount);
        }

        return $finalAmount;
    }
}
