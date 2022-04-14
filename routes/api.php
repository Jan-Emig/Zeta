<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignInController;
use App\Http\Controllers\MiscController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware('throttle:signin')->group(function () {
    Route::post('/signin', [SignInController::class, 'SignIn']);
});


Route::get('/ping', [MiscController::class, 'ping'])
    ->middleware('throttle:ping');

Route::get('/auth-check', [AuthController::class, 'checkAuthentication'])
    ->middleware('throttle:auth-check');

Route::get('/generate-username', [MiscController::class, 'generateUsername'])
    ->middleware('throttle:username-generator');
