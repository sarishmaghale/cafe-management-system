<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\TranslatorController;
use Spatie\Permission\Models\Role;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/user', [UserController::class, 'showLogInPage'])->name('LogInForm');
Route::post('/LogInAttempt', [UserController::class, 'userLogin'])->name('LogInSubmit');
Route::post('/logout', [UserController::class, 'userLogOut'])->name('logout');


Route::middleware(['auth'])->group(function () {

    Route::get('/', [HomeController::class, 'index']);

    Route::get('/products', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductController::class, 'store'])
        ->name('products.store')->middleware(('role:admin'));
    Route::get('/products/{id}', [ProductController::class, 'edit'])
        ->name('products.edit')->middleware(('role:admin'));
    Route::put('/products/{id}', [ProductController::class, 'update'])
        ->name('products.update')->middleware(('role:admin'));

    Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
    Route::get('/stations/{id}', [StationController::class, 'show'])->name('stations.show');
    Route::get('/addStations', [StationController::class, 'addNewStation'])
        ->name('stations.add')->middleware(('role:admin'));
    Route::post('/stations', [StationController::class, 'store'])
        ->name('stations.store')->middleware(('role:admin'));

    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::delete('/orders', [OrderController::class, 'delete'])->name('orders.delete');

    Route::get('/billings/{id}', [BillingController::class, 'show'])->name('billings.initiate');
    Route::put('/billings/{id}', [BillingController::class, 'update'])->name('billings.update');
    Route::get('/bills', [BillingController::class, 'showBills'])->name('bills.show');
    Route::get('/billDetails', [BillingController::class, 'showBillDetail'])->name('bills.detail');

    Route::get('/translator', [TranslatorController::class, 'index'])->name('translator.index');
    Route::post('/translator', [TranslatorController::class, 'translate'])->name('translator.translate');
});
