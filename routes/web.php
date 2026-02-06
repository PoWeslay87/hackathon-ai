<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\AdminAuthController;

// Public Routes
Route::get('/', [AiController::class, 'index']);
Route::post('/beranda', [AiController::class, 'ask'])->name('beranda.ask');
Route::post('/beranda-reset', [AiController::class, 'reset'])->name('beranda.reset');

// Auth Routes
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Protected Governance Routes
Route::middleware(['admin.gate'])->group(function () {
    Route::get('/dashboard', [AiController::class, 'dashboard'])->name('dashboard');
    Route::get('/audit-logs', [AiController::class, 'audit'])->name('audit.index');
    Route::patch('/audit-logs/{id}/status', [AiController::class, 'updateAuditStatus'])->name('audit.update-status');
    Route::delete('/audit-logs/{id}', [AiController::class, 'destroyAuditLog'])->name('audit.destroy');
    
    Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
    Route::post('/knowledge', [KnowledgeController::class, 'store'])->name('knowledge.store');
    Route::delete('/knowledge/{id}', [KnowledgeController::class, 'destroy'])->name('knowledge.destroy');
});
