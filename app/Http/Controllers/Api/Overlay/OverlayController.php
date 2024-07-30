<?php

namespace App\Http\Controllers\Api\Overlay;

use App\Http\Controllers\Controller;
use App\Http\Resources\Donate\DonateResource;
use App\Http\Resources\Overlay\TargetResource;
use App\Models\Target;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OverlayController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/overlay/donate_alert",
     * operationId="donateOverlay",
     * tags={"Overlay"},
     * summary="Get streamer donates",
     * @OA\Parameter(name="key",in="query",description="sdfsdfdfdf",required=true),
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
    public function donateAlert(Request $request)
    {
        $streamer = User::where('uuid', $request->key)->first();
        if (!$streamer) {
            abort(404, 'Invalid key');
        }
        $transaction = $streamer->transactionsReceived()->whereHas('payment')->where('watched_at', null)->limit(1)->first();
        if ($transaction) {
            return sendResponse('new donate', [
                'id' => $transaction->id,
                'amount' => $transaction->amount,
                'fullname' => $transaction->fullname,
                'description' => $transaction->description,
            ]);
        } else {
            return sendResponse('', []);
        }
    }

    /**
     * @OA\Patch(
     * path="/api/overlay/donate/{transaction_id}",
     * operationId="markAsWatchedDonate",
     * tags={"Overlay"},
     * summary="Mark a donate as watched",
     * @OA\Parameter(name="transaction_id",in="path",description="id of a transaction",required=true),
     * @OA\Parameter(name="key",in="query",description="sdfsdfdfdf",required=true),
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
    public function markAsWatchedDonate(Transaction $transaction, Request $request)
    {
        $streamer = User::where('uuid', $request->key)->first();
        if (!$streamer) {
            abort(404, 'Invalid key');
        }
        if ($streamer->id == $transaction->streamer_id) {
            if ($transaction->watched_at == null) {
                $transaction->update([
                    'watched_at' => now(),
                ]);
                return sendResponse('donate marked as watched', '');
            } else {
                return sendError('Watched before');
            }
        }
        abort(400);
    }

    /**
     * @OA\Get(
     * path="/api/overlay/latest_donates",
     * operationId="getLastDonates",
     * tags={"Overlay"},
     * summary="Get last donates",
     * security={ {"sanctum": {} }},
     * @OA\Parameter(name="key",in="query",description="sdfsdfdfdf",required=true),
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
    public function latestDonates(Request $request)
    {
        $streamer = User::where('uuid', $request->key)->first();
        if (!$streamer) {
            abort(404, 'Invalid key');
        }
        $donates = $streamer->transactionsReceived()->where('is_paid', 1)->where('type', 'donate')->orderBy('id','desc')->paginate(10);
        return sendResponse('Donate that I paid', [
            'donates' => DonateResource::collection($donates),
            'pagination' => paginateResponse($donates),
        ]);
    }

    /**
     * @OA\Get(
     * path="/api/overlay/donate/{target_id}",
     * operationId="getSpecificTargetData",
     * tags={"Overlay"},
     * summary="Get target info",
     * @OA\Parameter(name="target_id",in="path",description="id of a target",required=true),
     * @OA\Parameter(name="key",in="query",description="sdfsdfdfdf",required=true),
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
    public function getTarget(Request $request, Target $target)
    {
        $streamer = User::where('uuid', $request->key)->first();
        if (!$streamer) {
            abort(404, 'Invalid key');
        }
        if ($streamer->id == $target->user_id) {
            return sendResponse('Target into', new TargetResource($target));
        }
        abort(400);
    }
}
