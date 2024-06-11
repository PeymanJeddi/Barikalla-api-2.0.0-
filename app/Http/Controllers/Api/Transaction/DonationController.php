<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Donation\DonationStoreController;
use App\Models\Kind;
use App\Models\Transaction;
use App\Models\User;
use App\Services\DonateAmountService;
use App\Services\PaymentService;

class DonationController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/transaction/donate",
     * operationId="createDonation",
     * tags={"Transaction"},
     * summary="Create donations",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt transaction",
     *    @OA\JsonContent(
     *       required={"streamer_username", "amount", "phone_number", "fullname"},
     *       @OA\Property(property="streamer_username", type="string", format="string", example="4example"),
     *       @OA\Property(property="amount", type="integer", format="tooman", example="1000"),
     *       @OA\Property(property="phone_number", type="string", format="string", example="09000000000"),
     *       @OA\Property(property="fullname", type="string", format="string", example="my full name"),
     *       @OA\Property(property="description", type="text", format="text", example="this is test description."),
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
    public function makeDonate(DonationStoreController $request)
    {
        $user = auth()->user();
        $streamer = $this->getStreamer($request->streamer_username);
        $finalAmount = $this->calculateAmount($streamer, $request->amount);
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'streamer_id' => $streamer->id,
            'amount' => $finalAmount,
            'raw_amount' => $request->amount,
            'fullname' => $request->fullname,
            'description' => $request->description,
            'mobile' => $user->mobile,
            'type' => 'donate',
        ]);

        $paymentUrl = PaymentService::makePayment($transaction, $user, $finalAmount);


        return sendResponse('transaction created', [
            'payment_url' => $paymentUrl,
        ]);
    }

    private function getStreamer($username): User
    {
        return User::where('username', $username)->first();
    }

    private  function calculateAmount(User $streamer, int $amount): int
    {
        $finalAmount = $amount;
        if ($streamer->gateway->is_donator_pay_wage || $streamer->gateway->is_donator_pay_wage == '') {
            $finalAmount += DonateAmountService::calculateWage($streamer, $amount);
        }

        if ($streamer->gateway->is_donator_pay_tax || $streamer->gateway->is_donator_pay_tax == '') {
            $finalAmount += DonateAmountService::calculateTax($amount);
        }

        return $finalAmount;
    }

}
