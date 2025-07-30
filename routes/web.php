<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZohoFormController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/zoho-form', [ZohoFormController::class, 'index']);
Route::post('/zoho-form', [ZohoFormController::class, 'store']);
/*Route::get('/zoho/token', function () {
    $code = 'treterer'; 
    $token = \App\Services\ZohoAuthService::exchangeCodeForToken($code);
    
    dd([
        'access_token' => $token->getAccessToken(),
        'refresh_token' => $token->getRefreshToken(),
    ]);
});*/

require __DIR__.'/auth.php';
