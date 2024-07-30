<?php

namespace App\Http\Controllers\Api\Streamer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Steamer\StreamerResource;
use App\Models\User;

class StreamerController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/gateway/{username}",
     * operationId="streamerShow",
     * tags={"Streamer"},
     * summary="Get streamer gateway into",
     * @OA\Parameter(name="username",in="path",description="4example",required=true),
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
    public function show(User $user)
    {
        $user->gateway->view_count += 1;
        $user->gateway->save();
        return sendResponse('اطلاعات استریمر', new StreamerResource($user));
    }
}
