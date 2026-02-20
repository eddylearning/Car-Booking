<?php

use App\Services\MpesaService;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;

// Admin Controllers
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\UserCarController;
use App\Http\Controllers\ContactMessageController;

// Employee Controllers
use App\Http\Controllers\Employee\MpesaController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Employee\MessageController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

// User Controllers
use App\Http\Controllers\Employee\MpesaCallbackController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\CarController as AdminCarController;
use App\Http\Controllers\User\BookingController as UserBookingController;

use App\Http\Controllers\User\MessageController as UserMessageController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/cars', [FrontendController::class, 'cars'])->name('cars.index');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/contact', [ContactMessageController::class, 'contact'])->name('contact');
// Route::get('/contact', [FrontendController::class, 'contact'])->name('contact.show');
Route::post('/contact', [ContactMessageController::class, 'submit'])->name('contact.submit');


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
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
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

Route::get('/verify-email', EmailVerificationPromptController::class)
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

Route::put('/password', [PasswordController::class, 'update'])
    ->middleware('auth')
    ->name('password.update');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
->prefix('admin')
->name('admin.')
->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('dashboard');

    // Cars CRUD
    Route::resource('cars', AdminCarController::class);

    // Bookings
    Route::get('bookings', [AdminBookingController::class, 'index'])
        ->name('bookings.index');

    // Payments
    Route::get('payments', [AdminPaymentController::class, 'index'])
    ->name('payments.index');

    Route::get('payments/{payment}', [AdminPaymentController::class, 'show'])
    ->name('payments.show');

    Route::post('payments/{payment}/complete', [AdminPaymentController::class, 'markCompleted'])
    ->name('payments.complete');


    // Messages
    Route::resource('messages', AdminMessageController::class);

    // Reports (PDF)
    Route::get('reports/bookings', [ReportController::class, 'bookings'])
        ->name('reports.bookings');

    Route::get('reports/payments', [ReportController::class, 'payments'])
        ->name('reports.payments');

    Route::get('reports/revenue', [ReportController::class, 'revenue'])
        ->name('reports.revenue');
});


/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:employee'])
->prefix('employee')
->name('employee.')
->group(function () {

    // Employee Dashboard
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Employee Bookings
    |--------------------------------------------------------------------------
    */
    // LIST BOOKINGS
Route::get('bookings', [EmployeeBookingController::class, 'index'])
    ->name('bookings.index');

// SHOW CREATE FORM
Route::get('bookings/create', [EmployeeBookingController::class, 'create'])
    ->name('bookings.create');

// STORE NEW BOOKING
Route::post('bookings', [EmployeeBookingController::class, 'store'])
    ->name('bookings.store');

// SHOW BOOKING DETAILS
Route::get('bookings/{id}', [EmployeeBookingController::class, 'show'])
    ->name('bookings.show');

// SHOW EDIT FORM
Route::get('bookings/{id}/edit', [EmployeeBookingController::class, 'edit'])
    ->name('bookings.edit');

// UPDATE BOOKING
Route::put('bookings/{id}', [EmployeeBookingController::class, 'update'])
    ->name('bookings.update');

// DELETE BOOKING
Route::delete('bookings/{id}', [EmployeeBookingController::class, 'destroy'])
    ->name('bookings.destroy');

//BOOKING MESSAGE
Route::post('messages/{booking}/confirm', 
    [EmployeeMessageController::class, 'confirmAvailability']
)->name('messages.confirm');

Route::post('messages/stk', 
    [EmployeeMessageController::class, 'sendStkPush']
)->name('messages.stk');


    /*
    |--------------------------------------------------------------------------
    | Employee Payments (Includes MPESA Test)
    |--------------------------------------------------------------------------
    */

    Route::prefix('/employee/payments')->group(function () {

        // All payments
        Route::get('/', [EmployeePaymentController::class, 'index'])
            ->name('payments.index');

        // Trigger payment for booking
        Route::post('/pay/{booking}', [EmployeePaymentController::class, 'pay'])
            ->name('payments.pay');

        // Show Test STK Page
        Route::get('/test', [MpesaController::class, 'showTestPage'])
            ->name('payments.test');

        // Trigger Test STK Push
        Route::post('/test/stk', [MpesaController::class, 'testStkPush'])
            ->name('payments.test.stk');

    });

  /*
  |--------------------------------------------------------------------------
  | Employee Messages
  |--------------------------------------------------------------------------
 */
//index (list all conversations)
Route::get('message', [EmployeeMessageController::class, 'index'])
 ->name('messages.index');

//show (specific conversations for bookings)
Route::get('message/{booking}', [EmployeeMessageController::class, 'show'])
->name('messages.show');

//store (send a reply)
Route::post('message',[EmployeeMessageController::class, 'store'])
->name('messages.store');

//Custom actions for availabol and stk
 Route::post('messages/{booking}/confirm', 
    [EmployeeMessageController::class, 'confirmAvailability']
)->name('messages.confirm');

Route::post('messages/stk', [EmployeeMessageController::class, 'sendStkPush'])->name('messages.stk');
});

//Route::prefix('employee')
//     ->name('employee.')
//     ->group(function () {
//         Route::resource('messages', EmployeeMessageController::class);
//     });
    
    //BOOKING MESSAGE
//   Route::post('messages/{booking}/confirm', 
//     [EmployeeMessageController::class, 'confirmAvailability']
// )->name('messages.confirm');

// Route::post('messages/stk', [EmployeeMessageController::class, 'sendStkPush'])->name('messages.stk');

// });


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])
->prefix('user')
->name('user.')
->group(function () {

    // User Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])
        ->name('dashboard');

    // Cars list
    Route::get('cars', [UserCarController::class, 'index'])
        ->name('cars.index');

    Route::get('cars/{car}', [UserCarController::class, 'show'])
            ->name('cars.show');

    // Booking creation
    Route::get('bookings/create/{car}', [UserBookingController::class, 'create'])
        ->name('bookings.create');    

    Route::post('bookings/store', [UserBookingController::class, 'store'])
        ->name('bookings.store');

    //Booking show
    Route::get('bookings/{booking}', [UserBookingController::class, 'show'])
        ->name('bookings.show');    

    // Booking list
    Route::get('bookings', [UserBookingController::class, 'index'])
        ->name('bookings.index');

    // Messages
    Route::resource('/user/messages', UserMessageController::class);

     Route::post('messages/{booking}/yes',
            [UserMessageController::class, 'confirmYes']
        )->name('messages.yes');

    Route::post('messages/{booking}/no',
            [UserMessageController::class, 'confirmNo']
        )->name('messages.no');
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
