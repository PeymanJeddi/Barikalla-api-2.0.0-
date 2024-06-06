<?php

namespace App\Http\Controllers\Api\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Gateway\GatewayUpdateRequest;
use App\Http\Resources\Common\KindResource;
use App\Http\Resources\Gateway\GatewayResource;
use App\Models\Kind;

class GatewayController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/streamer/gateway",
     * operationId="gatewayIndex",
     * tags={"Gateway"},
     * summary="Get gateway detail",
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
        return sendResponse('اطلاعات درگاه', new GatewayResource($user->gateway));
    }


    /**
     * @OA\Patch(
     * path="/api/streamer/gateway",
     * operationId="gatewayUpdate",
     * tags={"Gateway"},
     * summary="Update gateway details",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt gateway detail",
     *    @OA\JsonContent(
     *       required={"nickname", "is_payment_active", "job_id", "min_donate", "max_donate", "is_donator_pay_wage", "is_donator_pay_tax"},
     *       @OA\Property(property="nickname", type="string", format="string", example="bigezmog"),
     *       @OA\Property(property="is_payment_active", type="boolean", format="boolean", example=1),
     *       @OA\Property(property="job_id", type="integer", format="integer", example=5),
     *       @OA\Property(property="min_donate", type="integer", format="integer", example=6000),
     *       @OA\Property(property="max_donate", type="integer", format="integer", example=10000),
     *       @OA\Property(property="is_donator_pay_wage", type="boolean", format="boolean", example=1),
     *       @OA\Property(property="is_donator_pay_tax", type="boolean", format="boolean", example=0),
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
    public function update(GatewayUpdateRequest $request)
    {
        $user = $request->user();
        $user->gateway()->update([
            ...$request->validated(),
        ]);
        return sendResponse('اطلاعات درگاه آپدیت شد', new GatewayResource($user->gateway));
    }

    /**
     * @OA\Get(
     * path="/api/streamer/gateway/config",
     * operationId="gatewayConfig",
     * tags={"Gateway"},
     * summary="Get gateway config",
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
    public function config()
    {
        $jobs = Kind::findByKey('job')->get();
        return sendResponse('', [
            'jobs' => KindResource::collection($jobs),
        ]);
    }
}
