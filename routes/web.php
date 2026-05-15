<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// 1. Welcome Route
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

// 4. Admin Panel Routes
Route::middleware([
    'auth',
    'role:admin|user-manager|role-manager|permissions-manager|creator|editor|deleter|viewer'
])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('roles', RoleController::class)->except(['show']);
    Route::resource('permissions', PermissionController::class)->except(['show']);

    Route::post('/roles/{role}/permissions', [RoleController::class, 'syncPermissions'])
        ->name('roles.sync');
});