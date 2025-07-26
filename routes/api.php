<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\VisitorAnalyticsController;

// Route::post('/send-otp', [RegisteredUserController::class, 'sendOtp']);
// Route::post('/verify-otp', [RegisteredUserController::class, 'verifyOtp']);

// Route::domain('sazumme-tech-laravel.test')->name('admin.')->group(function () {
// Route::domain('sazumme.com')->name('admin.')->group(function () {
// Authenticated admin routes
// Route::middleware(['multi.auth:auth,admin'])->group(function () {
Route::get('/visitors/summary', [VisitorAnalyticsController::class, 'summary']);
Route::get('/visitors/source-chart', [VisitorAnalyticsController::class, 'sourceChart']);
//     });
// });
