<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/user/get-profile",
     * operationId="getUserProfile",
     * tags={"User"},
     * summary="Get user profile data",
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
    public function show()
    {
        $user = auth()->user();
        if ($user->username == null) {
            $step = 'signup';
        } else if ($user->first_name == null || $user->last_name == null || $user->description == null || $user->birthday == null || $user->avatar()->count() == 0) {
            $step = 'incomplete';
        } else {
            $step = 'completed';
        }
        return sendResponse('User data', ['user' => new UserResource($user), 'step' => $step]);
    }

    /**
     * @OA\Patch(
     * path="/api/user/edit-profile",
     * operationId="updateUser",
     * tags={"User"},
     * summary="Update user info",
     * security={ {"sanctum": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt update user",
     *    @OA\JsonContent(
     *       required={"first_name", "last_name", "username"},
     *       @OA\Property(property="nickname", type="string", format="string", example="bigezmog"),
     *       @OA\Property(property="username", type="string", format="string", example="4example"),
     *       @OA\Property(property="referral_username", type="string", format="string", example="4example"),
     *       @OA\Property(property="email", type="string", format="email", example="test@test.com"),
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
    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();
        if (($user->referral_username == null && $request->has('referral_username')) && ($user->username == null && $request->has('username'))) {
            $user->referral_username = $request->referral_username;
            $user->save();
        }
        $user->update([
            ...$request->validated(),
        ]);
        return sendResponse('User updated', new UserResource($user));
    }

    /**
     * @OA\Delete(
     * path="/api/user/logout",
     * operationId="logoutUser",
     * tags={"User"},
     * summary="Logout user",
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
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return sendResponse('User logged out', []);
    }
}
