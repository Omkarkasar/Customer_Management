<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'customeradd'])->name('customeradd');
Route::post('customerstore', [CustomerController::class, 'customerstore'])->name('customerstore');
Route::get('customerget', [CustomerController::class, 'customerget'])->name('customerget');
Route::get('customeredit/{id}', [CustomerController::class, 'customeredit'])->name('customeredit');
Route::post('customerupdate/{id}', [CustomerController::class, 'customerupdate'])->name('customerupdate');
Route::delete('customerdelete/{id}', [CustomerController::class, 'customerdelete']);
