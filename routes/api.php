<?php

use App\Http\Controllers\Api\Attachment\AttachmentController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Gateway\GatewayController;
use App\Http\Controllers\Api\Payment\CreditController;
use App\Http\Controllers\Api\Payment\DonationController;
use App\Http\Controllers\Api\Payment\SubscribeController;
use App\Http\Controllers\Api\Payment\VerifyController;
use App\Http\Controllers\Api\Wallet\CheckoutController;
use App\Http\Controllers\Api\Target\TargetController;
use App\Http\Controllers\Api\User\Link\LinkController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('sendotp', [AuthenticationController::class, 'sendOtp']);
    Route::post('validateotp', [AuthenticationController::class, 'validateOtp']);
});


Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('user')->group(function() {
        Route::get('/get-profile', [UserController::class, 'show']);
        Route::patch('/edit-profile', [UserController::class, 'update']);
        Route::delete('/logout', [UserController::class, 'logout']);

        Route::prefix('link')->group(function () {
            Route::get('/', [LinkController::class, 'index']);
            Route::patch('/', [LinkController::class, 'update']);
            Route::get('/config', [LinkController::class, 'config']);
        });
    });

    Route::prefix('dashboard')->group(function() {
        Route::prefix('streamer')->group(function() {
            Route::apiResource('target', TargetController::class);
        });
    });

    Route::prefix('payment')->group(function () {
        // Route::post('/transaction', [PaymentController::class, 'createTransaction']);
    });
   
    Route::prefix('wallet')->group(function () {
        Route::get('/checkoutrequest', [CheckoutController::class, 'index']);
        Route::post('/checkoutrequest', [CheckoutController::class, 'store']);
    });

    Route::prefix('payment')->group(function () {
        Route::post('/donate', [DonationController::class, 'makeDonate']);
        Route::post('/addcredit', [CreditController::class, 'addCredit']);
        Route::post('/buysubscribe', [SubscribeController::class, 'buySubscribe']);
    });

    Route::prefix('attachment')->group(function() {
        Route::post('/', [AttachmentController::class, 'upload']);
        Route::delete('/{attachment}', [AttachmentController::class, 'destroy']);
    });

    Route::prefix('streamer')->group(function() {
        Route::get('/config', [GatewayController::class, 'config']);
        Route::patch('/gateway', [GatewayController::class, 'update']);
        Route::get('/gateway', [GatewayController::class, 'index']);
    });
});

Route::prefix('payment')->group(function () {
    Route::post('/verify', [VerifyController::class, 'verifyTransaction']);
});