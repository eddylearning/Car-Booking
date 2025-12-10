<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\ReportController;

// Employee Controllers
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\BookingController as EmployeeBookingController;
use App\Http\Controllers\Employee\PaymentController as EmployeePaymentController;
use App\Http\Controllers\Employee\MpesaController;
use App\Http\Controllers\Employee\MpesaCallbackController;
use App\Http\Controllers\Employee\MessageController as EmployeeMessageController;

// User Controllers
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserCarController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\MessageController as UserMessageController;

use App\Services\MpesaService;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| Breeze / Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Cars CRUD
    Route::resource('/admin/cars', AdminCarController::class);

    // Bookings
    Route::get('/admin/bookings', [AdminBookingController::class, 'index'])
        ->name('admin.bookings.index');

    // Payments
    Route::get('/admin/payments', [AdminPaymentController::class, 'index'])
        ->name('admin.payments.index');

    // Messages
    Route::resource('/admin/messages', AdminMessageController::class);

    // Reports (PDF)
    Route::get('/admin/reports/bookings', [ReportController::class, 'bookings'])
        ->name('admin.reports.bookings');

    Route::get('/admin/reports/payments', [ReportController::class, 'payments'])
        ->name('admin.reports.payments');

    Route::get('/admin/reports/revenue', [ReportController::class, 'revenue'])
        ->name('admin.reports.revenue');
});


/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:employee'])->group(function () {

    // Employee Dashboard
    Route::get('/employee/dashboard', [EmployeeController::class, 'dashboard'])
        ->name('employee.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Employee Bookings
    |--------------------------------------------------------------------------
    */
    Route::get('/employee/bookings', [EmployeeBookingController::class, 'index'])
        ->name('employee.bookings.index');

    Route::get('/employee/bookings/{id}', [EmployeeBookingController::class, 'show'])
        ->name('employee.bookings.show');

    /*
    |--------------------------------------------------------------------------
    | Employee Payments (Includes MPESA Test)
    |--------------------------------------------------------------------------
    */

    Route::prefix('/employee/payments')->group(function () {

        // All payments
        Route::get('/', [EmployeePaymentController::class, 'index'])
            ->name('employee.payments.index');

        // Trigger payment for booking
        Route::post('/pay/{booking}', [EmployeePaymentController::class, 'pay'])
            ->name('employee.payments.pay');

        // Show Test STK Page
        Route::get('/test', [MpesaController::class, 'showTestPage'])
            ->name('employee.payments.test');

        // Trigger Test STK Push
        Route::post('/test/stk', [MpesaController::class, 'testStkPush'])
            ->name('employee.payments.test.stk');

    });

    /*
    |--------------------------------------------------------------------------
    | Employee Messages
    |--------------------------------------------------------------------------
    */
    Route::resource('/employee/messages', EmployeeMessageController::class);
});


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])->group(function () {

    // User Dashboard
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])
        ->name('user.dashboard');

    // Cars list
    Route::get('/user/cars', [UserCarController::class, 'index'])
        ->name('user.cars.index');

    // Booking creation
    Route::get('/user/bookings/create/{car}', [UserBookingController::class, 'create'])
        ->name('user.bookings.create');

    Route::post('/user/bookings/store', [UserBookingController::class, 'store'])
        ->name('user.bookings.store');

    // Booking list
    Route::get('/user/bookings', [UserBookingController::class, 'index'])
        ->name('user.bookings.index');

    // Messages
    Route::resource('/user/messages', UserMessageController::class);
});


/*
|--------------------------------------------------------------------------
| Mpesa Callback (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::post('/mpesa/callback', [MpesaCallbackController::class, 'handle'])
    ->name('mpesa.callback');


/*
|--------------------------------------------------------------------------
| Developer Test Route (Optional)
|--------------------------------------------------------------------------
*/

Route::get('/test-mpesa', function () {
    $mpesa = new MpesaService();
    return $mpesa->stkPush(
        1,                     
        '254729237606',        
        'TestRef',             
        'Test STK Push'        
    );
});
