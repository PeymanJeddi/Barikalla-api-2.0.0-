<?php

namespace App\Http\Controllers\Api\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Wallet\WalletUpdateRequest;
use App\Http\Resources\Wallet\WalletResource;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/wallet",
     * operationId="walletIndex",
     * tags={"Wallet"},
     * summary="Get wallet detail",
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
    public function index()
    {
        $wallet = auth()->user()->wallet;
        return sendResponse('Wallet detail', new WalletResource($wallet));
    }

    /**
     * @OA\Patch(
     * path="/api/wallet",
     * operationId="walletUpdate",
     * tags={"Wallet"},
     * summary="Update wallet details",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt gateway detail",
     *    @OA\JsonContent(
     *       @OA\Property(property="shaba", type="string", format="number", example="0000000000000000", description="Send without country code"),
     *       @OA\Property(property="bank_account_number", type="string", format="number", example="00000000000"),
     *       @OA\Property(property="bank_card_number", type="string", format="number", example="0000000000000000"),
     *       @OA\Property(property="is_automatic_checkout", type="boolean", format="boolean", example=0),
     *       @OA\Property(property="automatic_checkout_cycle", type="string", format="enum", example="daily|weekly|monthly"),
     *       @OA\Property(property="automatic_checkout_min_amount", type="string", format="number(tooman)", example="20000"),
     *       @OA\Property(property="automatic_checkout_max_amount", type="string", format="number(tooman)", example="30000"),
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
    public function update(WalletUpdateRequest $request)
    {
        $user = auth()->user();
        $user->wallet()->update([
            ...$request->validated(),
        ]);
 
        return sendResponse('Wallet updated', new WalletResource($user->wallet));
    }
}
