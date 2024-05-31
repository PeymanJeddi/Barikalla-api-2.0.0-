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

    private static function makePayment(User $user, int $amount, Transaction $transaction): string
    {
        // Your specified fields for the payment gateway
        $data = [
            "CorporationPin" => config('app.payment_corporation_pin'),
            "Amount" => $amount * 10, // Assuming you need to convert to Rials for the API
            "OrderId" => $transaction->id, // Generating a unique order ID; adapt as necessary
            "CallBackUrl" => "http://localhost:8000/api/payment/verify",
            "AdditionalData" => "test",
            "Originator" => $user->mobile,
        ];

        try {
            $response = Http::post('https://pna.shaparak.ir/mhipg/api/Payment/NormalSale', $data);
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

    public static function verifyTransaction(string $token, Transaction $transaction,)
    {
        $corporationPin = config('app.payment_corporation_pin');

        try {
            $response = Http::post('https://pna.shaparak.ir/mhipg/api/Payment/confirm', [
                'CorporationPin' => $corporationPin,
                'Token' => $token
            ]);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
        $responseData = $response->json();

        $transaction->update([
            'is_paid' => 1,
        ]);

        $transaction->payment()->create([
            'token' => $token,
            'code' => 'test',
        ]);
        Log::info($responseData);
    }
}
