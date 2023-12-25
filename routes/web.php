<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [MainController::class, 'home']);

Route::middleware(['guest'])->group(function() {

  Route::get('/login/page', [MainController::class, 'loginPage'])->name('login');
  Route::post('/login', [MainController::class, 'login']);
  Route::get('/register/page', [MainController::class, 'registerPage']);
  Route::post('/register', [MainController::class, 'register']);

});

Route::middleware(['auth'])->group(function() {

  Route::get('/logout', [MainController::class, 'logout']);

  Route::get('/service', [ServiceController::class, 'index']);
  Route::get('/booking/page/{category}', [ServiceController::class, 'bookingPage']);
  Route::post('/booking', [ServiceController::class, 'booking']);
  Route::get('/myorder', [ServiceController::class, 'myorder']);

});


Route::get('/dashboard', [MainController::class, 'dashboard']);
Route::resource('/manage/user', UserController::class)->except(['create', 'show', 'edit']);
Route::resource('/manage/category', CategoryController::class)->except(['create', 'show', 'edit']);
Route::resource('/manage/booking', BookingController::class)->except(['create', 'show', 'edit']);
