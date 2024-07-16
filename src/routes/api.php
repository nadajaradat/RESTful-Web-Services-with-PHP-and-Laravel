<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\RegistrationController;

// Registration route
Route::post('/register', [AuthController::class, 'register']);

// Login route
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
    return response()->json(['message' => 'You are logged in!', $request->user()], 200);
});

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// meeting routes

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('meetings', MeetingController::class);
});

// registration routes

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('registrations', [RegistrationController::class, 'store']);
    Route::delete('registrations/{registration}', [RegistrationController::class, 'destroy']);
});
