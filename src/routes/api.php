<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\MeetingController;

// Registration route
Route::post('/register', [AuthController::class, 'register']);

// Login route
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/test', function (Request $request) {
    return response()->json(['message' => 'You are logged in!', $request->user()], 200);
});

// meeting routes

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('meetings', MeetingController::class);
});
