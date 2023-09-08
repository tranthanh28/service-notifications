<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

use App\Http\Controllers\Api\ReactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reaction'], function () {
    Route::get('/', [ReactionController::class, 'index']);
    // Route::get('/{id}', [ReactionController::class, 'show']);
    Route::post('/', [ReactionController::class, 'store']);
    Route::post('/export-excel', [ReactionController::class, 'exportExcel']);
    // Route::post('/dowload', [ReactionController::class, 'index']);
});

