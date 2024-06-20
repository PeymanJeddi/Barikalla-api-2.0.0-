<?php

namespace App\Http\Controllers\Api\Identity;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\IdentityUpdateRequest;
use App\Http\Resources\Identity\IdentityResource;
use Illuminate\Http\Request;

class IdentityController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/identity",
     * operationId="identityIndex",
     * tags={"Identity"},
     * summary="Get identity detail",
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
        return sendResponse('User identity information', new IdentityResource($user));
    }

    /**
     * @OA\Patch(
     * path="/api/identity",
     * operationId="identityUpdate",
     * tags={"Identity"},
     * summary="Update identity details",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt gateway detail",
     *    @OA\JsonContent(
     *       @OA\Property(property="first_name", type="string", format="string", example="name"),
     *       @OA\Property(property="last_name", type="string", format="string", example="last name"),
     *       @OA\Property(property="gender", type="enum", format="string", example="male|female|other"),
     *       @OA\Property(property="birthday", type="string", format="date", example="2000-02-03"),
     *       @OA\Property(property="national_id", type="string", format="string", example="0000000000"),
     *       @OA\Property(property="city_id", type="integer", format="integer", example="3"),
     *       @OA\Property(property="address", type="string", format="string", example="first streat"),
     *       @OA\Property(property="postalcode", type="string", format="string", example="0000000000"),
     *       @OA\Property(property="fix_phone_number", type="string", format="string", example="00000000"),
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
    public function update(IdentityUpdateRequest $request)
    {
        $user = auth()->user();
        $user->update([
            ...$request->validated(),
        ]);

        if (
            $user->first_name != null &&
            $user->last_name != null &&
            $user->gender != null &&
            $user->birthday != null &&
            $user->national_id != null &&
            $user->address != null &&
            $user->postalcode != null &&
            $user->fix_phone_number != null
        ) {
            $user->status = 'pending';
            $user->save();
        }

        return sendResponse('اطلاعات هویتی با موفقیت به روز رسانی شدند', new IdentityResource($user));
    }

    /**
     * @OA\Get(
     * path="/api/identity/config",
     * operationId="identityConfig",
     * tags={"Identity"},
     * summary="Get provinces and city list",
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
        
    }
}
