<?php

use App\Http\Controllers\App\PaymentMethod\PaypalController;
use App\Http\Controllers\App\PaymentMethod\RazorpayController;
use App\Http\Controllers\App\PaymentMethod\StripeController;
use App\Http\Controllers\App\SamplePage\ReportController;



// Report
Route::get('reports', [ReportController::class, 'index'])->name('report.index');


Route::get('stripe-status', [StripeController::class, 'stripeStatus'])
    ->name('payment_method.stripe-status');

Route::get('paypal-status', [PaypalController::class, 'paypalStatus'])
    ->name('payment_method.paypal-status');

Route::get('razorpay-status', [RazorpayController::class, 'razorpayStatus'])
    ->name('payment_method.razorpay-status');

Route::get('create-payment', [PaypalController::class, 'create'])
    ->name('create-payment');

Route::get('execute-payment', [PaypalController::class, 'execute'])
    ->name('execute-payment');

Route::get('cancel-payment', [PaypalController::class, 'cancel'])
    ->name('cancel-payment');


Route::post('razor-payment', [RazorpayController::class, 'razorPost'])
    ->name('razor-payment');

Route::get('razor-pay-information', [RazorpayController::class, 'razorPayInformation'])
    ->name('razor-pay-information');

