<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Payment\BuySubscribeRequest;
use App\Models\Kind;
use App\Models\Transaction;
use App\Services\PaymentService;

class SubscribeController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/payment/buysubscribe",
     * operationId="buySubscribe",
     * tags={"Payment"},
     * summary="Buy subscribe",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt transaction",
     *    @OA\JsonContent(
     *       required={"amount"},
     *       @OA\Property(property="months", type="integer", format="integer", example="2"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Your request has been successfully completed.",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="bool", example="true"),
     *       @OA\Property(property="message", type="string", example="Your request has been successfully completed."),
     *       @OA\Property(property="data"),
     *        )
     *     ),
     * )
     */
    public function buySubscribe(BuySubscribeRequest $request)
    {
        $user = $request->user();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'mobile' => $user->mobile,
            'type' => 'subscription',
        ]);
        $amount =  Kind::where('key', 'vip_package_price')->first()->value_2 * $request->months;
        $paymentUrl = PaymentService::makePayment($transaction, $user, $amount);
        return sendResponse('transaction created', [
            'payment_url' => $paymentUrl,
        ]);
    }
}
