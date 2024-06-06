<?php

namespace App\Http\Controllers\Api\User\Link;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Link\LinkUpdateRequest;
use App\Http\Resources\User\Link\LinkResource;
use App\Http\Resources\Common\KindResource;
use App\Models\Kind;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/user/link",
     * operationId="userLinkIndex",
     * tags={"User link"},
     * summary="Get user links",
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
        return sendResponse('Users link', LinkResource::collection($user->links));
        return $user->links;
    }

    /**
     * @OA\Patch(
     * path="/api/user/link",
     * operationId="userLinkUpdate",
     * tags={"User link"},
     * summary="Update links for user",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt streamer target",
     *    @OA\JsonContent(
     *       required={"title", "target"},
     *       @OA\Property(property="links", type="array", format="array", example={{"link_id": 5, "value": "iman", "alt": "test"}}, @OA\Items()),
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
    public function update(LinkUpdateRequest $request)
    {
        // TODO add link_id validation here
        $user   = $request->user();
        $user->links()->detach();
        foreach ($request->links as $link) {
            $user->links()->attach($link['link_id'], ['value' => $link['value'], 'alt' => $link['alt']]);
        }
        return sendResponse('لینک‌ها بروزرسانی شدند', LinkResource::collection($user->links));
    }

    /**
     * @OA\Get(
     * path="/api/user/link/config",
     * operationId="userConfig",
     * tags={"User link"},
     * summary="Get user config",
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
        $links = Kind::findByKey('link')->get();
        return sendResponse('config data', [
            'links' => KindResource::collection($links),
        ]);
    }
}
