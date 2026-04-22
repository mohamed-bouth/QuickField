<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Session\LoginController;
use App\Http\Controllers\Auth\Session\RegisterController;
use App\Http\Controllers\Public\DashboardController;
use App\Http\Controllers\Public\FieldController;
use App\Http\Controllers\Admin\FieldController as AdminFieldController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\PriceController as AdminPriceController;
use App\Http\Controllers\Public\ReservationController;
use App\Http\Controllers\Public\ReviewController;
use App\Http\Controllers\Public\PaymentController;

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
        Route::get('explore', [FieldController::class, 'index'])->name('public.fields.index');
        Route::get('field/details/{field}', [FieldController::class, 'show'])->name('public.fields.show');
        Route::post('field/details/{field}/reviews', [ReviewController::class, 'store'])->name('public.fields.reviews.store');
        Route::patch('field/details/{field}/reviews/{review}', [ReviewController::class, 'update'])->name('public.fields.reviews.update');
        Route::delete('field/details/{field}/reviews/{review}', [ReviewController::class, 'destroy'])->name('public.fields.reviews.destroy');
        Route::get('fields/{field}/reservations/events', [FieldController::class, 'events']);
        Route::get('manager/fields/{id}/blocks/create', [ReservationController::class, 'takeHour'])->name('public.fields.blocks.create');

        Route::post('payment/create-intent', [PaymentController::class, 'createIntent']);
        Route::post('payment/confirm', [PaymentController::class, 'confirm']);
        Route::get('payment/success/{reservation}', function (\App\Models\Reservation $reservation) {
            abort_unless((int) $reservation->user_id === (int) request()->user()->id, 403);

            return redirect()
                ->route('public.fields.show', $reservation->field_id)
                ->with('success', 'Payment completed successfully.');
        })->name('public.payment.success');
    }); 

    Route::middleware('role:super_admin|field_manager|field_guard')->group(function () {
            Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');

            Route::get('admin/fields', [AdminFieldController::class, 'index'])->name('admin.fields.index');
            Route::get('admin/fields/create', [AdminFieldController::class, 'create'])->name('admin.fields.create');
            Route::post('admin/fields', [AdminFieldController::class, 'store'])->name('admin.fields.store');
            Route::get('admin/fields/{field}', [AdminFieldController::class, 'show'])->name('admin.fields.show');
            Route::get('admin/fields/{id}/edit', [AdminFieldController::class, 'edit'])->name('admin.fields.edit');
            Route::put('admin/fields/{id}', [AdminFieldController::class, 'update'])->name('admin.fields.update');
            Route::delete('admin/fields/{id}', [AdminFieldController::class, 'destroy'])->name('admin.fields.destroy');
            Route::put('admin/fields/{field}/planning', [AdminFieldController::class, 'updatePlanning'])->name('admin.fields.planning.update');

            Route::get('admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
            Route::get('admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
            Route::delete("admin/users/destroy/{id}", [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

            Route::get("admin/reservations/", [AdminReservationController::class, 'index'])->name('admin.reservations.index');
            Route::patch('admin/reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])->name('admin.reservations.confirm');
            Route::patch('admin/reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->name('admin.reservations.cancel');

    });

});


