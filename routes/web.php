<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

require_once __DIR__ . '/admin.php';
require_once __DIR__ . '/user.php';



Route::redirect('/', 'user/home');

Route::get('/email/verify', function () {
    return view('authentication.verify-email');
})->middleware('auth')->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('user/home'); 
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware('guest')->group(function () {
    Route::get('/verify-otp', [RegisteredUserController::class, 'showOtpForm'])->name('otp.show');
    Route::post('/verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('otp.verify');
});


    Route::get('/security/reset-transition', function (\Illuminate\Http\Request $request) {

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect()->route('password.request');
    })->name('profile.forgot-password.transition');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('auth/{provider}/redirect', [SocialLoginController::class, 'redirect'])
    ->name('socialLogin');

Route::get('auth/{provider}/callback',[SocialLoginController::class, 'callback'])->name('socialCallback');
