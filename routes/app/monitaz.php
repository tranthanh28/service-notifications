<?php

use App\Http\Controllers\Monitaz\ReactionController;
use App\Http\Controllers\Monitaz\CrudController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reaction'], function () {
    Route::get('/', [ReactionController::class, 'index']);
    // Route::get('/{id}', [ReactionController::class, 'show']);
    // Route::post('/', [ReactionController::class, 'index']);
    // Route::post('/dowload', [ReactionController::class, 'index']);
    Route::resource('crud', CrudController::class);
});
