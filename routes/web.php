<?php

// 1. Correct Imports

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 2. Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 3. Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/upload', [DashboardController::class, 'upload'])->name('profile.upload');
});

// 4. Admin Routes - FIXED NAMESPACE
Route::middleware(['auth', 'permission:users-manage|roles-manage|permissions-manage'])->prefix('admin')->name('admin.')->group(function () {

    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class); // Standardized

    Route::post('/roles/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('roles.sync');
});