<?php

use App\Http\Controllers\Monitaz\ReactionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'reaction'], function () {
    Route::get('/', [ReactionController::class, 'index'])->name('reaction.index');
});
