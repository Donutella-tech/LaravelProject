<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;


Route::get('/', function () {
    return view('home');
});


Route::resource('news', NewsController::class);

Route::middleware("auth")->group(function()
{
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('list', ListController::class);

});
Route::middleware("guest")->group(function()
{
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register_process', [AuthController::class, 'register'])->name('register_process');
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');

});











Route::post('/login_process', [AuthController::class, 'login'])->name('login_process');




