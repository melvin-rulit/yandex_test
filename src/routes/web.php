<?php

use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
    return Inertia::render('App');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth:sanctum')->group(function () {
//Settings
    Route::get('/yandex/settings', [SettingsController::class, 'settings']);
    Route::post('/yandex/settings', [SettingsController::class, 'store']);
//Reviews
    Route::get('/reviews', [ReviewController::class, 'getReviewsForUser']);
});

require __DIR__ . '/auth.php';
