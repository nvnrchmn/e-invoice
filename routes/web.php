<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);

Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

Route::get('/invoices/verify/{id}', [InvoiceController::class, 'verifyPage'])->name('invoices.verify');
