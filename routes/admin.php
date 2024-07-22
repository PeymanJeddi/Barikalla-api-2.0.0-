<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Kind\KindCategoryController;
use App\Http\Controllers\Admin\Kind\KindController;
use App\Http\Controllers\Admin\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::resource('users', UserController::class);
Route::resource('/kindcategory', KindCategoryController::class);
Route::resource('kindcategory.kind', KindController::class);