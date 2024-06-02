<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Donation\DonationStoreController;
use App\Models\Transaction;
use App\Models\User;
use App\Services\DonationService;
use App\Services\PaymentService;
use App\Services\WalletService;
use Illuminate\Http\Request;

class DonationController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/payment/donate",
     * operationId="createDonation",
     * tags={"Payment"},
     * summary="Create donations",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt transaction",
     *    @OA\JsonContent(
     *       required={"streamer_username", "amount", "mobile", "fullname"},
     *       @OA\Property(property="streamer_username", type="string", format="string", example="4example"),
     *       @OA\Property(property="amount", type="integer", format="tooman", example="1000"),
     *       @OA\Property(property="mobile", type="string", format="string", example="09000000000"),
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
        $user = $this->getUser($request->mobile);
        $streamer = $this->getStreamer($request->streamer_username);
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'streamer_id' => $streamer->id,
            'amount' => $request->amount,
            'fullname' => $request->fullname,
            'description' => $request->description,
            'mobile' => $user->mobile,
            'type' => 'donate',
        ]);

        $paymentUrl = PaymentService::makePayment($transaction, $user,$request->amount);


        return sendResponse('transaction created', [
            'payment_url' => $paymentUrl,
        ]);
    }

    private function checkUserExist($mobile): bool
    {
        return User::where('mobile', $mobile)->exists();
    }

    private function createUser($mobile): User
    {
        return User::create([
            'mobile' => $mobile,
        ]);
    }

    private function getUser($mobile): User
    {
        return ($this->checkUserExist($mobile)) ? User::where('mobile', $mobile)->first() : $this->createUser($mobile);
    }

    private function getStreamer($username): User
    {
        return User::where('username', $username)->first();
    }
}
