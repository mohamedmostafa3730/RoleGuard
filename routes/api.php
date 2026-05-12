<?php

use App\Http\Controllers\Api\PermissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Protected API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('permissions', PermissionController::class);
});