<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Resources\Common\TransactionResource;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/payment",
     * operationId="paymentIndex",
     * tags={"Payment"},
     * summary="Get payment list",
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
        $user = auth()->user();
        $transactions = $user->allTransactions;
        $transactions = paginate($transactions, 10);
        return sendResponse('All successful transactions', [
            'transactions' => TransactionResource::collection($transactions),
            'pagination' => paginateResponse($transactions),
        ]);
    }
}
