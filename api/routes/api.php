<?php

use App\Http\Controllers\BBAppearanceController;
use App\Http\Controllers\BCSAppearanceController;
use App\Http\Controllers\CharacterController;
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

Route::prefix('characters')->group(function () {
    Route::get('', [CharacterController::class, 'index']);
    Route::get('/{character_id}', [CharacterController::class, 'show']);
    Route::get('/quotes/{character_name}', [CharacterController::class, 'quotes']);
});

Route::prefix('bb-appearances')->group(function () {
    Route::get('seasons', [BBAppearanceController::class, 'seasons']);
});

Route::prefix('bcs-appearances')->group(function () {
    Route::get('seasons', [BCSAppearanceController::class, 'seasons']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
