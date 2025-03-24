<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,UserController,TaskController};
use App\Http\Controllers\Auth\{LoginController, RegisterController};
use App\Http\Controllers\Admin\{DashboardController};

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::name('frontend.')->group(function(){

    //Register
    Route::controller(RegisterController::class)->group(function() {
        Route::get('register', 'showRegistrationForm')->name('register.show');
        Route::post('register', 'register')->name('register');
    });

    //Login
    Route::controller(LoginController::class)->group(function() {
        Route::get('login', 'showLoginForm')->name('login.show');
        Route::post('login', 'login')->name('login');
    });
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    //Check email & contact information
    Route::controller(UserController::class)->group(function() {
        Route::post('check-user-email', 'checkEmail')->name('check.user.email');
        Route::post('check-password-strength', 'checkPasswordStrength')->name('check.password-strength');
    });

    Route::get('/', [HomeController::class, 'index'])->name('home');
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        /* Dashboard */
        Route::get('/dashboard',  'dashboard')->name('dashboard.index');
    });

    /* User */
    Route::get('users/listing',  [UserController::class, 'listing'])->name('users.listing');
    Route::resource('users', UserController::class, ['names' => 'users']);

    Route::get('tasks/listing',  [TaskController::class, 'listing'])->name('tasks.listing');
    Route::resource('tasks', TaskController::class);

    Route::controller(UserController::class)->group(function() {
        Route::post('check-email', 'checkEmail')->name('check.email');
    });

    Route::post('assign-task',  [TaskController::class, 'userAssignTask'])->name('users.assignTask');
});
// require __DIR__.'/admin.php';
