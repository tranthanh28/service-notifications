<?php

use App\Http\Controllers\Monitaz\ReactionController;
use App\Http\Controllers\Monitaz\CrudController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reaction'], function () {
    Route::get('/', [ReactionController::class, 'index'])->name('reaction.index');
    Route::resource('crud', CrudController::class);
});
