<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;

Route::apiResource('clients', ClientController::class);
Route::apiResource('invoices', InvoiceController::class);
