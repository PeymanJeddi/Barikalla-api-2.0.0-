<?php

use App\Http\Controllers\Api\Attachment\AttachmentController;
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Donate\DonateController;
use App\Http\Controllers\Api\Gateway\GatewayController;
use App\Http\Controllers\Api\Identity\IdentityController;
use App\Http\Controllers\Api\Overlay\OverlayController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Transaction\CreditController;
use App\Http\Controllers\Api\Transaction\DonationController;
use App\Http\Controllers\Api\Transaction\SubscribeController;
use App\Http\Controllers\Api\Transaction\VerifyController;
use App\Http\Controllers\Api\Province\ProvinceController;
use App\Http\Controllers\Api\Streamer\StreamerController;
use App\Http\Controllers\Api\Wallet\CheckoutController;
use App\Http\Controllers\Api\Target\TargetController;
use App\Http\Controllers\Api\User\Link\LinkController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Wallet\WalletController;
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
        Route::get('/', [WalletController::class, 'index']);
        Route::patch('/', [WalletController::class, 'update']);
        Route::get('/checkoutrequest', [CheckoutController::class, 'index']);
        Route::post('/checkoutrequest', [CheckoutController::class, 'store']);
        Route::get('/log', [WalletController::class, 'log']);

    });

    Route::prefix('transaction')->group(function () {
        Route::post('/donate', [DonationController::class, 'makeDonate']);
        Route::post('/addcredit', [CreditController::class, 'addCredit']);
        Route::post('/buysubscribe', [SubscribeController::class, 'buySubscribe']);
    });

    Route::prefix('attachment')->group(function() {
        Route::post('/', [AttachmentController::class, 'store']);
        Route::delete('/{attachment}', [AttachmentController::class, 'destroy']);
        Route::get('/config', [AttachmentController::class, 'config']);
    });

    Route::prefix('streamer')->group(function() {
        Route::get('/gateway/config', [GatewayController::class, 'config']);
        Route::patch('/gateway', [GatewayController::class, 'update']);
        Route::get('/gateway', [GatewayController::class, 'index']);
    });

    
    Route::prefix('identity')->group(function () {
        Route::get('/', [IdentityController::class, 'index']);
        Route::patch('/', [IdentityController::class, 'update']);
    });

    Route::prefix('donate')->group(function () {
        Route::get('/paid', [DonateController::class, 'donatePaid']);
        Route::get('/received', [DonateController::class, 'donateReceived']);
    });

    Route::prefix('province')->group((function () {
        Route::get('/', [ProvinceController::class, 'province']);
        Route::Get('/{kind}', [ProvinceController::class, 'city']);
    }));

    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index']);
    });
});

Route::prefix('transaction')->group(function () {
    Route::post('/verify', [VerifyController::class, 'verifyTransaction']);
});
Route::get('/gateway/{user:username}', [StreamerController::class, 'show']);
Route::prefix('overlay')->group(function () {
    Route::get('/donate', [OverlayController::class, 'donate']);
    Route::get('/donates', [OverlayController::class, 'donates']);
});