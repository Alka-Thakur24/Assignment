<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('HeaderView');
});

Route::get('add-store-details', [MainController::class, 'Index'])->name('store.add');
Route::post('add-store-data', [MainController::class, 'Store'])->name('store.store');
Route::get('get-customer', [MainController::class, 'GetCustomer'])->name('store.customer');
