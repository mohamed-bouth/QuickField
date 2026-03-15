<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Session\LoginController;
use App\Http\Controllers\Auth\Session\RegisterController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [RegisterController::class, 'create'])->name('register');

Route::post('register', [RegisterController::class, 'store']);

Route::get('login', [LoginController::class, 'create'])->name('login');

Route::post('login', [LoginController::class, 'store']);

Route::get('logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('public.dashboard.index', [DashboardController::class, 'index'])->name('public.dashboard.index'); 
