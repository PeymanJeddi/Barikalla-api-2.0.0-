<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Donation\DonationStoreRequest;
use App\Http\Requests\Api\Transaction\DonateWithWalletStoreRequest;
use App\Models\Kind;
use App\Models\Target;
use App\Models\Transaction;
use App\Models\User;
use App\Services\DonateAmountService;
use App\Services\PaymentService;
use App\Services\TargetService;
use App\Services\WalletService;

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
     *       @OA\Property(property="sandbox", type="boolean", format="boolean", example="0"),
     *       @OA\Property(property="with_wallet", type="boolean", format="boolean", example="0"),
     *       @OA\Property(property="target_id", type="integer", format="integer", example="64"),
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
    public function makeDonate(DonationStoreRequest $request)
    {
        $user = auth()->user();
        $streamer = $this->getStreamer($request->streamer_username);

        if ($request->sandbox && $user->hasRole('developer')) {
            return $this->generateFakeDonate($streamer, $user, $request->amount, $request->fullname, $request->target_id);
        }

        if ($request->with_wallet) {
            return $this->donateWithWallet($user, $streamer, $request);
        }


        $target = null;
        if ($request->has('target_id')) {
            $target = Target::find($request->target_id);
            if ($target->user_id != $streamer->id ) {
                return sendError('تارگت انتخاب شده مربوط به استریمر دیگری نیست', '', 403);
            }

            if (!$target->is_active) {
                return sendError('تارگت غیر فعال می‌باشد');
            }
        }
    
        if ($streamer->gateway->is_payment_active) {
            $finalAmount = $this->calculateAmount($streamer, $request->amount);
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'streamer_id' => $streamer->id,
                'target_id' => $target?->id,
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
        } else {
            return sendError('دونیت غیر فعال می‌باشد');
        }
    }

    private function getStreamer($username): User
    {
        return User::where('username', $username)->first();
    }

    private  function calculateAmount(User $streamer, int $amount): int // TODO: move this function into service
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

    private function generateFakeDonate(User $streamer, User $user, int $amount, string $fullname, int $target_id = null) 
    {
        if ($target_id) {
            $target = Target::find($target_id);
            if ($target->user_id != $streamer->id) {
                return sendError('عدم دسترسی', '', 403);
            }
        }
        $finalAmount = $this->calculateAmount($streamer, $amount);
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'streamer_id' => $streamer->id,
            'target_id' => $target_id,
            'amount' => $finalAmount,
            'raw_amount' => $amount,
            'fullname' => $fullname,
            'description' => 'sandbox',
            'mobile' => $user->mobile,
            'type' => 'donate',
            'is_paid' => 1,
        ]);


        $amountToBeCharge = DonateAmountService::calculateAmount($streamer, $transaction);
        if (@$target) {
            TargetService::chargetTarget($target, $amountToBeCharge);
        }
        WalletService::chargeWallet($streamer, $amountToBeCharge);
        $transaction->payment()->create([
            'token' => 'sandbox',
            'code' => 'sandbox',
            'user_credit_after_payment' => WalletService::getUserCredit($transaction->user),
            'streamer_credit_after_payment' => WalletService::getUserCredit($transaction->streamer),
        ]);
        return sendResponse('دونیت با موفقیت ایجاد شد', '');
    }

    private function donateWithWallet(User $user, User $streamer, $request)
    {
        $amount  = $request->amount;
        if ($request->target_id) {
            $target = Target::find($request->target_id);
            if ($target->user_id != $streamer->id) {
                return sendError('عدم دسترسی', '', 403);
            }
        }

        if(!WalletService::CheckWalletBalance($user, $amount)) {
            return sendError('موجودی کیف پول شما کافی نمی‌باشد');
        }
        
        WalletService::withdrawFromWallet($user, $amount);
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'streamer_id' => $streamer->id,
            'target_id' => $request->target_id,
            'amount' => $amount,
            'raw_amount' => $amount,
            'fullname' => $user->fullname,
            'description' => $request->description,
            'mobile' => $user->mobile,
            'type' => 'donate_with_wallet',
            'is_paid' => 1,
        ]);

        if (@$target) {
            TargetService::chargetTarget($target, $amount);
        }
        WalletService::chargeWallet($streamer, $amount);
        $transaction->payment()->create([
            'token' => 'donate_with_wallet',
            'code' => 'donate_with_wallet',
            'user_credit_after_payment' => WalletService::getUserCredit($transaction->user),
            'streamer_credit_after_payment' => WalletService::getUserCredit($transaction->streamer),
        ]);
        return sendResponse('دونیت با موفقیت انجام شد', []);
    }
}
