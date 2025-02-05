<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusPassController;
use App\Http\Controllers\WebPageController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [WebPageController::class, 'home'])->name('homePage');
Route::get('/register', [WebPageController::class, 'register'])->name('registerPage');
Route::get('/login', [WebPageController::class, 'login'])->name('loginPage');

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordPage'])->name('forgotPasswordPage');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');

// Student Routes
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/generate-pass', [WebPageController::class, 'generatePass'])->name('generatePass');
    Route::get('/view-pass', [WebPageController::class, 'viewPass'])->name('viewPass');
    Route::post('/generate-ticket', [BusPassController::class, 'store'])->name('generatePass.store');


    Route::get('/edit-pass/{id}', [BusPassController::class, 'edit'])->name('editPass');
    Route::post('/update-pass/{id}', [BusPassController::class, 'update'])->name('updatePass');

    Route::get('/renew-pass/{id}', [BusPassController::class, 'renew'])->name('renewPass');
    Route::post('/renew-pass/{id}', [BusPassController::class, 'update'])->name('renewPass.store');
    Route::post('/process-payment/{id}', [BusPassController::class, 'processPayment'])->name('processPayment');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/user-management', [AdminController::class, 'userManagement'])->name('admin.user-management');
    Route::get('/admin/pass-management', [AdminController::class, 'passManagement'])->name('admin.pass-management');
    Route::get('/admin/pass-approve/{id}', [AdminController::class, 'approvePass'])->name('admin.pass-approve');
    Route::get('/admin/pass-reject/{id}', [AdminController::class, 'rejectPass'])->name('admin.pass-reject');
    Route::get('/admin/get-payment/{id}', [AdminController::class, 'getPaymentDetails']);
});
