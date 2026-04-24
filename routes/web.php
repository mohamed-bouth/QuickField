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
use App\Http\Controllers\Public\ManagerAccountRequestController as PublicManagerAccountRequestController;
use App\Http\Controllers\Admin\ManagerAccountRequestController as AdminManagerAccountRequestController;

Route::middleware('guest')->group(function () {

    Route::get('/', [PublicManagerAccountRequestController::class, 'landing'])->name('manager-requests.landing');
    Route::post('manager-account-requests', [PublicManagerAccountRequestController::class, 'store'])->name('manager-requests.store');
    Route::get('manager-account-requests/check', [PublicManagerAccountRequestController::class, 'check'])->name('manager-requests.check');

    Route::get('register', [RegisterController::class, 'create'])->name('register');

    Route::post('register', [RegisterController::class, 'store']);

    Route::get('login', [LoginController::class, 'create'])->name('login');

    Route::post('login', [LoginController::class, 'store']);
});


Route::middleware('auth')->group(function () {
        Route::get('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::middleware('role:player')->group(function () {


        Route::get('home', [DashboardController::class, 'index'])->name('public.dashboard.index');
        Route::get('explore', [FieldController::class, 'index'])->middleware('permission:fields.browse')->name('public.fields.index');
        Route::get('field/details/{field}', [FieldController::class, 'show'])->middleware('permission:fields.browse')->name('public.fields.show');
        Route::post('field/details/{field}/reviews', [ReviewController::class, 'store'])->middleware('permission:reviews.create')->name('public.fields.reviews.store');
        Route::patch('field/details/{field}/reviews/{review}', [ReviewController::class, 'update'])->middleware('permission:reviews.create')->name('public.fields.reviews.update');
        Route::delete('field/details/{field}/reviews/{review}', [ReviewController::class, 'destroy'])->middleware('permission:reviews.create')->name('public.fields.reviews.destroy');
        Route::get('fields/{field}/reservations/events', [FieldController::class, 'events'])->middleware('permission:fields.browse');
        Route::get('manager/fields/{id}/blocks/create', [ReservationController::class, 'takeHour'])->middleware('permission:reservations.create')->name('public.fields.blocks.create');
        Route::get('my-reservations', [ReservationController::class, 'history'])->middleware('permission:tickets.view')->name('public.reservations.history');
        Route::get('reservation/{reservation}/continue', [ReservationController::class, 'continuePayment'])->middleware('permission:reservations.create')->name('public.reservations.continue-payment');
        Route::patch('reservation/{reservation}/cancel', [ReservationController::class, 'cancel'])->middleware('permission:reservations.cancel')->name('public.reservations.cancel');

        Route::post('payment/create-intent', [PaymentController::class, 'createIntent'])->middleware('permission:payments.deposit.pay');
        Route::post('payment/confirm', [PaymentController::class, 'confirm'])->middleware('permission:payments.deposit.pay');
        Route::get('payment/success/{reservation}', function (\App\Models\Reservation $reservation) {
            abort_unless((int) $reservation->user_id === (int) request()->user()->id, 403);

            return redirect()
                ->route('public.fields.show', $reservation->field_id)
                ->with('success', 'Payment completed successfully.');
        })->middleware('permission:payments.deposit.pay')->name('public.payment.success');

        Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    }); 

    Route::middleware('role:super_admin|field_manager|field_guard')->group(function () {
            Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])
                ->middleware('permission:finance.dashboard.view|manager.dashboard.view|guard.mobile.access')
                ->name('admin.dashboard.index');

            Route::get('admin/fields', [AdminFieldController::class, 'index'])->middleware('permission:fields.manage')->name('admin.fields.index');
            Route::get('admin/fields/create', [AdminFieldController::class, 'create'])->middleware(['permission:fields.manage', 'role:field_manager'])->name('admin.fields.create');
            Route::post('admin/fields', [AdminFieldController::class, 'store'])->middleware(['permission:fields.manage', 'role:field_manager'])->name('admin.fields.store');
            Route::get('admin/fields/{field}', [AdminFieldController::class, 'show'])->middleware('permission:fields.manage')->name('admin.fields.show');
            Route::get('admin/fields/{id}/edit', [AdminFieldController::class, 'edit'])->middleware('permission:fields.manage')->name('admin.fields.edit');
            Route::put('admin/fields/{id}', [AdminFieldController::class, 'update'])->middleware('permission:fields.manage')->name('admin.fields.update');
            Route::patch('admin/fields/{field}/validation', [AdminFieldController::class, 'updateValidation'])->middleware(['permission:fields.manage', 'role:super_admin'])->name('admin.fields.validation.update');
            Route::delete('admin/fields/{id}', [AdminFieldController::class, 'destroy'])->middleware('permission:fields.manage')->name('admin.fields.destroy');
            Route::put('admin/fields/{field}/planning', [AdminFieldController::class, 'updatePlanning'])->middleware('permission:planning.manage')->name('admin.fields.planning.update');

            Route::get('admin/users', [AdminUserController::class, 'index'])->middleware('role_or_permission:super_admin|staff.manage|users.blacklist.manage')->name('admin.users.index');
            Route::get('admin/users/create', [AdminUserController::class, 'create'])->middleware('permission:staff.manage')->name('admin.users.create');
            Route::delete("admin/users/destroy/{id}", [AdminUserController::class, 'destroy'])->middleware('role_or_permission:super_admin|staff.manage|users.blacklist.manage')->name('admin.users.destroy');

            Route::get("admin/reservations/", [AdminReservationController::class, 'index'])->middleware('permission:planning.daily.view')->name('admin.reservations.index');
            Route::patch('admin/reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])->middleware('permission:planning.manage')->name('admin.reservations.confirm');
            Route::patch('admin/reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->middleware('permission:planning.manage')->name('admin.reservations.cancel');

    });

            Route::middleware('role:super_admin')->group(function () {
                Route::get('admin/manager-account-requests', [AdminManagerAccountRequestController::class, 'index'])->middleware('permission:manager-requests.review')->name('admin.manager-requests.index');
                Route::patch('admin/manager-account-requests/{managerRequest}/approve', [AdminManagerAccountRequestController::class, 'approve'])->middleware('permission:manager-requests.review')->name('admin.manager-requests.approve');
                Route::patch('admin/manager-account-requests/{managerRequest}/reject', [AdminManagerAccountRequestController::class, 'reject'])->middleware('permission:manager-requests.review')->name('admin.manager-requests.reject');
            });

});


