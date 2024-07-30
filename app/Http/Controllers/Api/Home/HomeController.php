<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/home/",
     * operationId="gatHome",
     * tags={"Home"},
     * summary="Get home information",
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
        $streamerProfit = $user->transactionsReceived()->where('is_paid', 1)->where('type', 'donate')->with('payment.profit')->get()->pluck('payment.profit.amount_streamer_charged')->toArray();
        $mostExpensiveDonate =  $user->transactionsReceived()->where('is_paid', 1)->where('type', 'donate')->orderBy('raw_amount', 'desc')->first();
        return sendResponse('Home information', [
            'streamer_profit' => array_sum($streamerProfit),
            'most_expensive_donate' => $mostExpensiveDonate->raw_amount,
        ]);
    }
}
