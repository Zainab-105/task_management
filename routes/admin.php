<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Admin\{DashboardController};

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(DashboardController::class)->group(function () {
    /* Dashboard */
    Route::get('/',  'dashboard')->name('dashboard.index');
    Route::get('/dashboard',  'dashboard')->name('dashboard.index');
});

Route::name('admin.')->group(function(){
    Route::controller(LoginController::class)->group(function() {
        Route::post('logout', 'logout')->name('logout');
    });
});