<?php

use App\Http\Controllers\App\Roles\RoleController;
use App\Http\Controllers\App\Users\UserController;
use App\Http\Controllers\App\Users\AppUserController;
use App\Http\Controllers\App\Users\UserRoleController;
use App\Http\Controllers\App\Users\UserSocialLinkController;
use App\Http\Controllers\App\Auth\AuthenticateUserController;
use App\Http\Controllers\App\Notification\NotificationController;
use App\Http\Controllers\App\Settings\ReCaptchaSettingController;
use App\Http\Controllers\App\PaymentMethod\StripeController;

Route::get('check', function (){
    dd(redirect(config('app.url') . '/payment-view'));
});
Route::get('/test', [AuthenticateUserController::class, 'registerView']);
