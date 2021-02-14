<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Open Routes
Route::group(['namespace' => 'api'], function () 
{
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/login-app', [AuthController::class, 'thirdPartyLogin']);

    Route::get('/login/third-party/callback', [AuthController::class, 'thirdPartyCallback']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

