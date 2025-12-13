<?php

use App\Services\MpesaService;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\UserCarController;
use App\Http\Controllers\Employee\MpesaController;

// Employee Controllers
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Employee\MessageController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Employee\MpesaCallbackController;

// User Controllers
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Http\Controllers\User\MessageController as UserMessageController;

use App\Http\Controllers\Admin\BookingController as AdminBookingController;

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

// Include auth routes directly in web.php instead of external file
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Employee\BookingController as EmployeeBookingController;
use App\Http\Controllers\Employee\MessageController as EmployeeMessageController;
use App\Http\Controllers\Employee\PaymentController as EmployeePaymentController;

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');


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
    // LIST BOOKINGS
Route::get('/employee/bookings', [EmployeeBookingController::class, 'index'])
    ->name('employee.bookings.index');

// SHOW CREATE FORM
Route::get('/employee/bookings/create', [EmployeeBookingController::class, 'create'])
    ->name('employee.bookings.create');

// STORE NEW BOOKING
Route::post('/employee/bookings', [EmployeeBookingController::class, 'store'])
    ->name('employee.bookings.store');

// SHOW BOOKING DETAILS
Route::get('/employee/bookings/{id}', [EmployeeBookingController::class, 'show'])
    ->name('employee.bookings.show');

// SHOW EDIT FORM
Route::get('/employee/bookings/{id}/edit', [EmployeeBookingController::class, 'edit'])
    ->name('employee.bookings.edit');

// UPDATE BOOKING
Route::put('/employee/bookings/{id}', [EmployeeBookingController::class, 'update'])
    ->name('employee.bookings.update');

// DELETE BOOKING
Route::delete('/employee/bookings/{id}', [EmployeeBookingController::class, 'destroy'])
    ->name('employee.bookings.destroy');

//BOOKING MESSAGE
Route::post('/employee/messages/{booking}/confirm', 
    [EmployeeMessageController::class, 'confirmAvailability']
)->name('employee.messages.confirm');

Route::post('/employee/messages/stk', 
    [EmployeeMessageController::class, 'sendStkPush']
)->name('employee.messages.stk');


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
Route::prefix('employee')
    ->name('employee.')
    ->group(function () {
        Route::resource('messages', EmployeeMessageController::class);
    });

    //BOOKING MESSAGE
Route::post('/employee/messages/{booking}/confirm', 
    [EmployeeMessageController::class, 'confirmAvailability']
)->name('employee.messages.confirm');

Route::post('/employee/messages/stk', 
    [EmployeeMessageController::class, 'sendStkPush']
)->name('employee.messages.stk');

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
