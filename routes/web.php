<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerifyOTPController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\BranchesController; // Ensure this controller exists in the specified namespace
use App\Http\Controllers\UserController; // Ensure this controller exists in the specified namespace
use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\CaissesController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServicesController;

Route::get('/', function () {
    return redirect()->route('login');
});
// routes/web.php
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

// --- Routes pour la vérification OTP ---
Route::post('/verifi-numero', [VerifyOTPController::class, 'verifiNumero'])->name('verifi-numero');
Route::get('/verifi-otp', [VerifyOTPController::class, 'verifiOTP'])->name('verifi-otp');
Route::post('/verification-otp/resend', [VerifyOTPController::class, 'resendCode'])->name('verificationOTP.resend');
Route::post('/verification-otp', [VerifyOTPController::class, 'verifyCode'])->name('verificationOTP.check');
Route::get('/mot-de-passe', [VerifyOTPController::class, 'motpasse'])->name('mot-de-passe');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    Route::get('/clients', [ClientController::class, 'index'])->name('client.index');
    
});

require __DIR__ . '/auth.php';
