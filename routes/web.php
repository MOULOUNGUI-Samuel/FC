<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/particulier', [ClientController::class, 'index'])->name('liste.index');
    Route::get('/fondEntitee', [ClientController::class, 'index1'])->name('liste.index1');
    
});

require __DIR__ . '/auth.php';
