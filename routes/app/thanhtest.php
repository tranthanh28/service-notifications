<?php

use App\Http\Controllers\App\Test\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/test', [TestController::class, 'test'])
    ->name('test.index');
