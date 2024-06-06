<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\SendOtpRequest;
use App\Http\Requests\Api\Auth\ValidateOtpRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Otp;
use App\Models\User;

class AuthenticationController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/auth/sendotp",
     * operationId="sendOTP",
     * tags={"Auth"},
     * summary="Send otp",
     * description="Send otp code to the entered mobile number.",
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt send otp",
     *    @OA\JsonContent(
     *       @OA\Property(property="phone_number", type="string", format="string", example="09000000000"),
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
    public function sendOtp(SendOtpRequest $request)
    {
        $response = Otp::generateCode($request->phone_number, 'verifybarikalla');
        return $response;
    }

        /**
     * @OA\Post(
     * path="/api/auth/validateotp",
     * operationId="validateOTP",
     * tags={"Auth"},
     * summary="Validate OTP",
     * @OA\RequestBody(
     *    required=true,
     *    description="attempt send otp",
     *    @OA\JsonContent(
     *       @OA\Property(property="code", type="string", format="string", example="112233"),
     *       @OA\Property(property="phone_number", type="string", format="string", example="09000000000"),
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
    public function validateOtp(ValidateOtpRequest $request)
    {
        $mobile = $request->phone_number;

        $token = $this->getOtpToken($mobile, $request->code);
        if (empty($token)) {
            return sendError('کد وارد شده صحیح نمی‌باشد', [], 403);
        } else {
            if (empty($this->expiryCheck($token->code))) {
                return sendError('کد وارد شده منقضی شده است', [], 403);
            }
        }

        $user = $this->authenticateUser($mobile);
        $token = $this->generateAPIToken($user);
        if ($user->username == null) {
            $userStatus = 'signup';
        } else if ($user->first_name == null || $user->last_name == null || $user->description == null || $user->birthday == null || $user->avatar()->count() == 0) {
            $userStatus = 'incomplete';
        } else {
            $userStatus = 'completed';
        }
        return sendResponse('کاربر با موفقیت وارد شد', ['user' => new UserResource($user), 'token' => $token, 'step' => $userStatus]);
    }

    private function authenticateUser($mobile)
    {
        return User::firstOrCreate([
            'mobile' => $mobile
        ]);
    }
    private function getOtpToken($mobile, $code)
    {
        return Otp::where('mobile', $mobile)->where('code', $code)->first();
    }

    private function generateAPIToken($user)
    {
        return $user->createToken('apiToken')->plainTextToken;
    }

    private function expiryCheck($code)
    {
        return Otp::where('code', $code)->where('expires_at', '>=', now())->first();
    }

}
