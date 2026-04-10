<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Session\LoginController;
use App\Http\Controllers\Auth\Session\RegisterController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

Route::middleware('guest')->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('register', [RegisterController::class, 'create'])->name('register');

    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('login');

    Route::post('login', [LoginController::class, 'store']);
});


Route::middleware('auth')->group(function () {
        Route::get('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::middleware('role:player')->group(function () {


        Route::get('home', [DashboardController::class, 'index'])->name('public.dashboard.index');
    }); 

    Route::middleware('role:super_admin|field_manager|field_guard')->group(function () {
            Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');

            Route::get('admin/fields', [FieldController::class, 'index'])->name('admin.fields.index');
            Route::get('admin/fields/create', [FieldController::class, 'create'])->name('admin.fields.create');
            Route::post('admin/fields', [FieldController::class, 'store'])->name('admin.fields.store');
            Route::get('admin/fields/{id}', [FieldController::class, 'show'])->name('admin.fields.show');
            Route::get('admin/fields/{id}/edit', [FieldController::class, 'edit'])->name('admin.fields.edit');
            Route::put('admin/fields/{id}', [FieldController::class, 'update'])->name('admin.fields.update');
            Route::delete('admin/fields/{id}', [FieldController::class, 'destroy'])->name('admin.fields.destroy');
    });

});


