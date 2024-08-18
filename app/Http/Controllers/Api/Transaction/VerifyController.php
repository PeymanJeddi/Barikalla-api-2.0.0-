<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Events\DonateProcced;
use App\Http\Controllers\Controller;
use App\Models\Kind;
use App\Models\Target;
use App\Models\Transaction;
use App\Models\User;
use App\Services\DonateAmountService;
use App\Services\PaymentService;
use App\Services\TargetService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyController extends Controller
{
    public function verifyTransaction(Request $request)
    {
        $transaction = Transaction::where('order_id', $request->OrderId)->first();
        $streamer = $transaction->streamer;
        if ($request->status == 0) {

            if ($transaction->is_paid) {
                return sendError('تراکنش قبلا تایید شده است', '', 403);
            }

            $payment = PaymentService::verifyPayment($request->Token, $transaction);
            
            if ($transaction->type == 'donate') {
                $amountToBeCharge = DonateAmountService::calculateAmount($streamer, $transaction);
                WalletService::chargeWallet($streamer, $amountToBeCharge);
                
                if ($transaction->target_id != null) {
                    $target = Target::find($transaction->target_id);
                    TargetService::chargetTarget($target, $amountToBeCharge);
                }

                $payment->update([
                    'user_credit_after_payment' => WalletService::getUserCredit($transaction->user),
                    'streamer_credit_after_payment' => WalletService::getUserCredit($transaction->streamer),
                ]);
            } else if ($transaction->type == 'charge') {
                WalletService::chargeWallet($transaction->user, $transaction->raw_amount);
                $payment->update([
                    'user_credit_after_payment' => WalletService::getUserCredit($transaction->user),
                ]);
            } else if ($transaction->type == 'subscription') {
                $vipPackagePrice = Kind::where('key', 'vip_package_price')->first()->value_2;
                $months = $transaction->amount / $vipPackagePrice;
                $transaction->user->assignRole('vip');
            }

            return redirect("https://barikalla.com/checkout/result/success?id=$transaction->id&amount=$transaction->amount&order_id=$transaction->order_id&username=$streamer->username");
        }    
        return redirect("https://barikalla.com/checkout/result/failure?id=$transaction->id&amount=$transaction->amount&order_id=$transaction->order_id&username=$streamer->username");
    }

}
