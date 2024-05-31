<?php

use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Donation\DonationController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Target\TargetController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('sendotp', [AuthenticationController::class, 'sendOtp']);
    Route::post('validateotp', [AuthenticationController::class, 'validateOtp']);
});

Route::prefix('user')->middleware('auth:sanctum')->group(function() {
    Route::get('/get-profile', [UserController::class, 'show']);
    Route::patch('/edit-profile', [UserController::class, 'update']);
    Route::delete('/logout', [UserController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
   
    Route::prefix('dashboard')->group(function() {
        Route::prefix('streamer')->group(function() {
            Route::apiResource('target', TargetController::class);
        });
    });

    Route::prefix('payment')->group(function () {
        Route::post('/transaction', [PaymentController::class, 'createTransaction']);
    });
    
});

Route::prefix('payment')->group(function () {
    Route::post('/donate', [DonationController::class, 'makeDonate']);
    Route::post('/verify', [DonationController::class, 'verify']);
});