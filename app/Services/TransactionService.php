<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TransactionService extends Service
{
    public static function makeTransaction(User $user, User $streamer, int $amount, string $fullname, string $description = null)
    {
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'streamer_id' => $streamer->id,
            'amount' => $amount,
            'fullname' => $fullname,
            'description' => $description,
            'mobile' => $user->mobile,
            'type' => 'donate',
        ]);
        $paymentUrl = self::makePayment($user, $amount, $transaction);
        return $paymentUrl;
    }

    private static function generateOrderId(): int
    {
        do {
            $code = self::generateRandomNumber(); 
        } while (self::isOrderIdExists($code));

        return $code;
    }

    private static function isOrderIdExists($orderId): bool
    {
        return Transaction::where('order_id', $orderId)->exists();
    }

    private static function generateRandomNumber(): int
    {
        return mt_rand(1000000, 9999999) . mt_rand(1000000, 9999999);
    }

    private static function makePayment(User $user, int $amount, Transaction $transaction): string
    {
 

        try {
            do {
                $orderId = self::generateOrderId();
                $data = [
                    "CorporationPin" => config('app.payment_corporation_pin'),
                    "Amount" => $amount * 10,
                    "OrderId" => $orderId,
                    "CallBackUrl" => "http://localhost:8000/api/payment/verify",
                    "AdditionalData" => "test",
                    "Originator" => $user->mobile,
                ];
                $response = Http::post('https://pna.shaparak.ir/mhipg/api/Payment/NormalSale', $data);
            } while ($response->json()['status'] == -112);
            
            $transaction->update([
                'order_id' => $orderId,
            ]);

        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        $responseData = $response->json();
        if ($response->successful() && $responseData['status'] == 0) {
            $paymentUrl = 'https://pna.shaparak.ir/mhui/home/index/' . $responseData['token'];
            return $paymentUrl;
        } else {
            abort(500, $responseData['message']);
        }
    }

    public static function verifyTransaction(string $token, Transaction $transaction)
    {
        $corporationPin = config('app.payment_corporation_pin');

        try {
            Http::post('https://pna.shaparak.ir/mhipg/api/Payment/confirm', [
                'CorporationPin' => $corporationPin,
                'Token' => $token
            ]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }

        $transaction->update([
            'is_paid' => 1,
        ]);

        $payment = $transaction->payment()->create([
            'token' => $token,
            'code' => 'test',
        ]);

        WalletService::chargeWallet($transaction->streamer, $transaction->amount);
        return $payment;
    }
}
