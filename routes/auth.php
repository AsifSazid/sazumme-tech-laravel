<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PhoneVerificationController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminResetPasswordController;
use App\Http\Controllers\Admin\Auth\AdminPasswordController;

/*
|--------------------------------------------------------------------------
| Admin routes for main domain
|--------------------------------------------------------------------------
*/
// Route::domain('sazumme-tech-laravel.test')->name('admin.')->group(function () {
Route::domain('sazumme.com')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::middleware(['admin.guest'])->group(function () {
            Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');  // admin.login
            Route::post('login', [AuthenticatedSessionController::class, 'store']);

            Route::get('forgot-password', [AdminForgotPasswordController::class, 'create'])->name('password.request');
            Route::post('forgot-password', [AdminForgotPasswordController::class, 'store'])->name('password.email');
            Route::get('reset-password/{token}', [AdminResetPasswordController::class, 'create'])->name('password.reset');
            Route::post('reset-password', [AdminResetPasswordController::class, 'store'])->name('password.update');
        });
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('change-password', [AdminPasswordController::class, 'edit'])->name('password.edit');
        Route::put('change-password', [AdminPasswordController::class, 'update'])->name('password.change');

        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});

/*
|--------------------------------------------------------------------------
| Subdomain routes for user registration/login
|--------------------------------------------------------------------------
*/
// Route::domain('{subdomain}.sazumme-tech-laravel.test')->name('user.')->group(function () {
Route::domain('{subdomain}.sazumme.com')->name('user.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/verify-phone', [PhoneVerificationController::class, 'verifyPhone'])->name('verify.phone');
        Route::post('/phone-no/verification', [PhoneVerificationController::class, 'sendOtp'])->middleware('throttle:6,1')->name('phone-no.verification.send');
        Route::post('/verify-otp', [PhoneVerificationController::class, 'verifyOtp'])->name('verify-otp');

        Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::put('password', [PasswordController::class, 'update'])->name('password.update');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/dashboard', function () {
            return view('dashboard'); // user dashboard blade
        })->name('dashboard');
    });
});
