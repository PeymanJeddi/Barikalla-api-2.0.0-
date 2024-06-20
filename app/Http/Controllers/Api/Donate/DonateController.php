<?php

namespace App\Http\Controllers\Api\Donate;

use App\Http\Controllers\Controller;
use App\Http\Resources\Donate\DonateResource;

class DonateController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/donate/paid",
     * operationId="donatePaid",
     * tags={"Donate"},
     * summary="Get donates I paid",
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
    public function DonatePaid()
    {
        $user = auth()->user();
        $donates = $user->transactions()->where('is_paid', 1)->where('type', 'donate')->get();
        return sendResponse('Donate that I paid', DonateResource::collection($donates));
    }

    /**
     * @OA\Get(
     * path="/api/donate/received",
     * operationId="donateReceived",
     * tags={"Donate"},
     * summary="Get donates I received",
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
    public function DonateReceived()
    {
        $user = auth()->user();
        $donates = $user->transactionsReceived()->where('is_paid', 1)->where('type', 'donate')->get();
        return sendResponse('Donate that I received', DonateResource::collection($donates));
    }
}
