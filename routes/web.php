<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AssistanceTypeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public routes
Route::get('/assistance-types', [AssistanceTypeController::class, 'index'])->name('assistance-types.index');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Applications
    Route::resource('applications', ApplicationController::class);
    
    // Admin/Officer routes - will add authorization checks in controllers
    Route::resource('assistance-types', AssistanceTypeController::class)->except(['index']);
    
    // Application Management Routes
    Route::patch('/applications/{application}/review', [ApplicationController::class, 'review'])->name('applications.review');
    Route::patch('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::patch('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';