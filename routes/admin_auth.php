<?php

use App\Http\Controllers\AdminAuth\AuthenticatedSessionController as AdminAuthAuthenticatedSessionController;
use App\Http\Controllers\AdminAuth\ConfirmablePasswordController as AdminAuthConfirmablePasswordController;
use App\Http\Controllers\AdminAuth\EmailVerificationNotificationController as AdminAuthEmailVerificationNotificationController;
use App\Http\Controllers\AdminAuth\EmailVerificationPromptController as AdminAuthEmailVerificationPromptController;
use App\Http\Controllers\AdminAuth\NewPasswordController as AdminAuthNewPasswordController;
use App\Http\Controllers\AdminAuth\PasswordResetLinkController as AdminAuthPasswordResetLinkController;
use App\Http\Controllers\AdminAuth\VerifyEmailController as AdminAuthVerifyEmailController;
use Illuminate\Support\Facades\Route;

// Route::get('admin/register', [AdminAuthRegisteredUserController::class, 'create'])
//     ->middleware('guest')
//     ->name('admin.register');

// Route::post('admin/register', [AdminAuthRegisteredUserController::class, 'store'])
//     ->middleware('guest');

Route::get('/login', [AdminAuthAuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('admin.login');

Route::post('/login', [AdminAuthAuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [AdminAuthPasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('admin.password.request');

Route::post('/forgot-password', [AdminAuthPasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('admin.password.email');

Route::get('/reset-password/{token}', [AdminAuthNewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('admin.password.reset');

Route::post('/reset-password', [AdminAuthNewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('admin.password.update');

Route::get('/verify-email', [AdminAuthEmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth:admin')
    ->name('admin.verification.notice');

Route::get('/verify-email/{id}/{hash}', [AdminAuthVerifyEmailController::class, '__invoke'])
    ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
    ->name('admin.verification.verify');

Route::post('/email/verification-notification', [AdminAuthEmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:admin', 'throttle:6,1'])
    ->name('admin.verification.send');

Route::get('/confirm-password', [AdminAuthConfirmablePasswordController::class, 'show'])
    ->middleware('auth:admin')
    ->name('admin.password.confirm');

Route::post('/confirm-password', [AdminAuthConfirmablePasswordController::class, 'store'])
    ->middleware('auth:admin');

Route::post('/logout', [AdminAuthAuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('admin.logout');
