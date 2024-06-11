<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Wallet\AddCreditRequest;
use App\Models\Transaction;
use App\Services\DonateAmountService;
use App\Services\PaymentService;

class CreditController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/transaction/addcredit",
     * operationId="addCredit",
     * tags={"Transaction"},
     * summary="Add credit to profile",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt transaction",
     *    @OA\JsonContent(
     *       required={"amount"},
     *       @OA\Property(property="amount", type="integer", format="tooman", example="1000"),
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
    public function addCredit(AddCreditRequest $request)
    {
        $user = $request->user();
        $finalAmount = DonateAmountService::calculateTax($request->amount) + $request->amount;
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'amount' => $finalAmount,
            'raw_amount' => $request->amount,
            'mobile' => $user->mobile,
            'type' => 'charge',
        ]);
        
        $paymentUrl = PaymentService::makePayment($transaction, $user, $finalAmount);
        return sendResponse('transaction created', [
            'payment_url' => $paymentUrl,
        ]);
    }
}
