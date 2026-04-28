<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StripePaymentController;

Route::get('/', function () {
    return response()->json(['message' => 'Laravel Business Management System API is running']);
});

Route::resource('clients', ClientController::class);
Route::resource('invoices', InvoiceController::class);

Route::post('/stripe/checkout/{invoice}', [StripePaymentController::class, 'checkout'])->name('stripe.checkout');
Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
