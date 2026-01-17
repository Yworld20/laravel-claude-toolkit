<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Infrastructure\Http\Controller\UserController;

Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
});
