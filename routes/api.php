<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BoardApiController;

use App\Http\Controllers\Api\CardApiController;
use App\Http\Controllers\Api\CategoryApiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('categories', CategoryApiController::class);
Route::get('boards', [BoardApiController::class, 'index']);
Route::get('boards/{board}', [BoardApiController::class, 'show']);

Route::get('cards', [CardApiController::class, 'index']);
Route::get('cards/{card}', [CardApiController::class, 'show']);

// // Rotas protegidas
Route::middleware('web')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::post('boards', [BoardApiController::class, 'store']);
        Route::put('boards/{board}', [BoardApiController::class, 'update']);
        Route::delete('boards/{board}', [BoardApiController::class, 'destroy']);

        Route::post('cards', [CardApiController::class, 'store']);
        Route::put('cards/{card}', [CardApiController::class, 'update']);
        Route::delete('cards/{card}', [CardApiController::class, 'destroy']);
    });
});
