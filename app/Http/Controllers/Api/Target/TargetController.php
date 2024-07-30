<?php

namespace App\Http\Controllers\Api\Target;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Target\TargetStoreRequest;
use App\Http\Requests\Api\Target\TargetUpdateRequest;
use App\Http\Resources\Target\TargetListResource;
use App\Http\Resources\Target\TargetResource;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TargetController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/dashboard/streamer/target",
     * operationId="streamerTargetsList",
     * tags={"Target"},
     * summary="Get streamer targets",
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
        $targets = $user->targets()->paginate(10);
        return sendResponse('Streamer targets', [
            'targets' => TargetListResource::collection($targets),
            'pagination' => paginateResponse($targets)
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/dashboard/streamer/target",
     * operationId="streamerTargetCreate",
     * tags={"Target"},
     * summary="Create target for streamer",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt streamer target",
     *    @OA\JsonContent(
     *       required={"title", "target"},
     *       @OA\Property(property="title", type="string", format="string", example="test target"),
     *       @OA\Property(property="description", type="text", format="text", example="test description"),
     *       @OA\Property(property="target", type="integer", format="integer", example="300000", description="Price is in tooman"),
     *       @OA\Property(property="is_active", type="boolean", format="boolean", example="true"),
     *       @OA\Property(property="is_default", type="boolean", format="boolean", example="true"),
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
    public function store(TargetStoreRequest $request)
    {
        $target = $request->user()->targets()->create([
            ...$request->validated(),
        ]);
        return sendResponse('Target stored successfully', new TargetResource($target));
    }

    /**
     * @OA\Get(
     * path="/api/dashboard/streamer/target/{target_id}",
     * operationId="streamerTargetShow",
     * tags={"Target"},
     * summary="Get streamer target into",
     * security={ {"sanctum": {} }},
     * @OA\Parameter(name="target_id",in="path",description="14",required=true),
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
    public function show(Target $target)
    {
        Gate::authorize('view', $target);
        return sendResponse('Target into', new TargetResource($target));
    }

    /**
     * @OA\Patch(
     * path="/api/dashboard/streamer/target/{target_id}",
     * operationId="streamerTargetUpdate",
     * tags={"Target"},
     * summary="Update target for streamer",
     * security={ {"sanctum": {} }},
     * @OA\Parameter(name="target_id",in="path",description="14",required=true),
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt streamer target",
     *    @OA\JsonContent(
     *       required={"title", "target"},
     *       @OA\Property(property="title", type="string", format="string", example="test target"),
     *       @OA\Property(property="description", type="text", format="text", example="test description"),
     *       @OA\Property(property="target", type="integer", format="integer", example="300000", description="Price is in tooman"),
     *       @OA\Property(property="is_active", type="boolean", format="boolean", example="true"),
     *       @OA\Property(property="is_default", type="boolean", format="boolean", example="true"),
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
    public function update(TargetUpdateRequest $request, Target $target)
    {
        Gate::authorize('update', $target);
        $target->update([
            ...$request->validated(),
        ]);
        return sendResponse('Target updated', new TargetResource($target));
    }

    /**
     * @OA\Delete(
     * path="/api/dashboard/streamer/target/{target_id}",
     * operationId="deleteTarget",
     * tags={"Target"},
     * summary="Delete a target",
     * security={ {"sanctum": {} }},
     * @OA\Parameter(name="target_id",in="path",description="14",required=true),
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
    public function destroy(Target $target)
    {
        Gate::authorize('delete', $target);
        $target->delete();
        return sendResponse('Target deleted', []);
    }
}
