<?php

use App\Http\Controllers\AdminAuth\AuthenticatedSessionController as AdminAuthAuthenticatedSessionController;
use App\Http\Controllers\AdminAuth\ConfirmablePasswordController as AdminAuthConfirmablePasswordController;
use App\Http\Controllers\AdminAuth\EmailVerificationNotificationController as AdminAuthEmailVerificationNotificationController;
use App\Http\Controllers\AdminAuth\EmailVerificationPromptController as AdminAuthEmailVerificationPromptController;
use App\Http\Controllers\AdminAuth\NewPasswordController as AdminAuthNewPasswordController;
use App\Http\Controllers\AdminAuth\PasswordResetLinkController as AdminAuthPasswordResetLinkController;
use App\Http\Controllers\AdminAuth\RegisteredUserController as AdminAuthRegisteredUserController;
use App\Http\Controllers\AdminAuth\VerifyEmailController as AdminAuthVerifyEmailController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Route::get('/register', [RegisteredUserController::class, 'create'])
//     ->middleware('guest')
//     ->name('register');

// Route::post('/register', [RegisteredUserController::class, 'store'])
//     ->middleware('guest');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware(['auth.admin', 'auth.user'])
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth.admin', 'auth.user', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth.admin', 'auth.user', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware(['auth.admin', 'auth.user'])
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware(['auth.admin', 'auth.user']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth.admin', 'auth.user'])
    ->name('logout');



// Route::get('admin/register', [AdminAuthRegisteredUserController::class, 'create'])
//     ->middleware('guest')
//     ->name('register');

// Route::post('admin/register', [AdminAuthRegisteredUserController::class, 'store'])
//     ->middleware('guest');

// Route::get('admin/login', [AdminAuthAuthenticatedSessionController::class, 'create'])
//     ->middleware('guest')
//     ->name('admin.login');

// Route::post('admin/login', [AdminAuthAuthenticatedSessionController::class, 'store'])
//     ->middleware('guest');

// Route::get('admin/forgot-password', [AdminAuthPasswordResetLinkController::class, 'create'])
//     ->middleware('guest')
//     ->name('admin.password.request');

// Route::post('admin/forgot-password', [AdminAuthPasswordResetLinkController::class, 'store'])
//     ->middleware('guest')
//     ->name('admin.password.email');

// Route::get('admin/reset-password/{token}', [AdminAuthNewPasswordController::class, 'create'])
//     ->middleware('guest')
//     ->name('admin.password.reset');

// Route::post('admin/reset-password', [AdminAuthNewPasswordController::class, 'store'])
//     ->middleware('guest')
//     ->name('admin.password.update');

// Route::get('admin/verify-email', [AdminAuthEmailVerificationPromptController::class, '__invoke'])
//     ->middleware('auth:admin')
//     ->name('admin.verification.notice');

// Route::get('admin/verify-email/{id}/{hash}', [AdminAuthVerifyEmailController::class, '__invoke'])
//     ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
//     ->name('admin.verification.verify');

// Route::post('admin/email/verification-notification', [AdminAuthEmailVerificationNotificationController::class, 'store'])
//     ->middleware(['auth:admin', 'throttle:6,1'])
//     ->name('admin.verification.send');

// Route::get('admin/confirm-password', [AdminAuthConfirmablePasswordController::class, 'show'])
//     ->middleware('auth:admin')
//     ->name('admin.password.confirm');

// Route::post('admin/confirm-password', [AdminAuthConfirmablePasswordController::class, 'store'])
//     ->middleware('auth:admin');

// Route::post('admin/logout', [AdminAuthAuthenticatedSessionController::class, 'destroy'])
//     ->middleware('auth:admin')
//     ->name('admin.logout');
