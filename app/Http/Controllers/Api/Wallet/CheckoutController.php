<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Wallet\CheckoutStoreRequest;
use App\Http\Resources\Wallet\CheckoutResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/wallet/checkoutrequest",
     * operationId="streamerCheckoutRequestList",
     * tags={"Wallet"},
     * summary="Get streamer checkouts info",
     * security={ {"sanctum": {} }},
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
    public function index(Request $request)
    {
        $user = $request->user();
        $checkoutRequests = $user->checkoutRequests()->paginate(10);
        return sendResponse('درخواست‌های تسویه', [
            'checkouts' => CheckoutResource::collection($checkoutRequests),
            'pagination' => paginateResponse($checkoutRequests),
        ]);

    }

    /**
     * @OA\Post(
     * path="/api/wallet/checkoutrequest",
     * operationId="streamerCheckoutCreate",
     * tags={"Wallet"},
     * summary="Create streamer checkout request",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt streamer checkout",
     *    @OA\JsonContent(
     *       required={"title", "target"},
     *       @OA\Property(property="amount", type="integer", format="tooman", example=5000)
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
    public function store(CheckoutStoreRequest $request)
    {
        $user = $request->user();
        $wallet = $user->wallet;
        if ($request->amount > $wallet->credit) {
            throw ValidationException::withMessages(['amount' => 'مقدار تسویه نباید از اعتبار حساب بیشتر باشد']);
        }
        $checkoutRequest = $request->user()->checkoutRequests()->create([
            'current_credit' => $wallet->credit,
            'amount' => $request->amount,
        ]);
        $wallet->credit -= $request->amount;
        $wallet->save();
        
        return sendResponse('درخواست تسویه‌ی جدید ثبت شد', new CheckoutResource($checkoutRequest));
    }
}
