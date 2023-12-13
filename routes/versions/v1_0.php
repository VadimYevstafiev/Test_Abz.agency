<?php

use App\Http\Controllers\API\V1_0\AuthController;
use App\Http\Controllers\API\V1_0\RegisteredUserController;
use App\Http\Controllers\API\V1_0\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::post('register', RegisteredUserController::class)->name('register');
    Route::post('auth', AuthController::class)->name('auth');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{id}', [UsersController::class, 'show'])->where('id', '[0-9]+');
});
