<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//login
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// //logout
// Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::apiResource('/users', App\Http\Controllers\Api\UserController::class)->middleware('auth:sanctum');
// Route::get('/company', [App\Http\Controllers\Api\CompanyController::class, 'show'])->middleware('auth:sanctum');
// //checkin
// Route::post('/checkin', [App\Http\Controllers\Api\AttendaceController::class, 'checkin'])->middleware('auth:sanctum');

// //checkout
// Route::post('/checkout', [App\Http\Controllers\Api\AttendaceController::class, 'checkout'])->middleware('auth:sanctum');

// //is checkin
// Route::get('/is-checkin', [App\Http\Controllers\Api\AttendaceController::class, 'isCheckedin'])->middleware('auth:sanctum');

// //update profile
// Route::post('/update-profile', [App\Http\Controllers\Api\AuthController::class, 'updateProfile'])->middleware('auth:sanctum');

// //create permission
// Route::apiResource('/api-permissions', App\Http\Controllers\Api\PermissionController::class)->middleware('auth:sanctum');

// //notes
// Route::apiResource('/api-notes', App\Http\Controllers\Api\NoteController::class)->middleware('auth:sanctum');

// //update fcm token
// Route::post('/update-fcm-token', [App\Http\Controllers\Api\AuthController::class, 'updateFcmToken'])->middleware('auth:sanctum');

// //get attendance
// Route::get('/api-attendances', [App\Http\Controllers\Api\AttendaceController::class, 'index'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/company', [App\Http\Controllers\Api\CompanyController::class, 'show']);
    Route::post('/checkin', [App\Http\Controllers\Api\AttendaceController::class, 'checkin']);
    Route::post('/checkout', [App\Http\Controllers\Api\AttendaceController::class, 'checkout']);
    Route::get('/is-checkin', [App\Http\Controllers\Api\AttendaceController::class, 'isCheckedin']);
    Route::post('/update-profile', [App\Http\Controllers\Api\AuthController::class, 'updateProfile']);
    Route::apiResource('/api-permissions', App\Http\Controllers\Api\PermissionController::class);
    Route::apiResource('/api-notes', App\Http\Controllers\Api\NoteController::class);
    Route::post('/update-fcm-token', [App\Http\Controllers\Api\AuthController::class, 'updateFcmToken']);
    Route::get('/api-attendances', [App\Http\Controllers\Api\AttendaceController::class, 'index']);
    Route::get('/api-user/{id}', [App\Http\Controllers\Api\UserController::class, 'getUserId']);
    //update user
    Route::post('/api-user/edit', [App\Http\Controllers\Api\UserController::class, 'updateProfile']);

    Route::post('/check-qr', [App\Http\Controllers\Api\QrAbsenController::class, 'checkQR']);
});
