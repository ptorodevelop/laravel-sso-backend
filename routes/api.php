<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\ProcessController;
use App\Http\Controllers\Api\V2\AuthController as AuthControllerV2;
use App\Http\Controllers\Api\V2\ProcessController as ProcessControllerV2;
use App\Http\Controllers\Api\V3\AuthController as AuthControllerV3;
use App\Http\Controllers\Api\V3\ProcessController as ProcessControllerV3;

// V1
Route::prefix('v1')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/validate', [AuthController::class, 'validateToken']);
    Route::post('notifications/send', [NotificationController::class, 'send']);
    Route::middleware('auth:api')->get('process/restricted', [ProcessController::class, 'index']);
});

// // V2
// Route::prefix('v2')->group(function () {
//     Route::post('auth/login', [AuthControllerV2::class, 'login']);
//     Route::middleware('auth:api')->get('process/restricted', [ProcessControllerV2::class, 'index']);
// });

// // V3
// Route::prefix('v3')->group(function () {
//     Route::post('auth/login', [AuthControllerV3::class, 'login']);
//     Route::middleware('auth:api')->get('process/restricted', [ProcessControllerV3::class, 'index']);
// });
