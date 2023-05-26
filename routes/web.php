<?php

use App\Http\Controllers\Admin\Auth\ForgetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoignController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth
Route::get('login', [LoignController::class, 'create'])->middleware('guest')->name('login');
Route::post('authenticate', [LoignController::class, 'store'])->middleware('guest')->name('authenticate');
Route::post('logout', [LoignController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('forget-password', [ForgetPasswordController::class, 'create'])->middleware('guest')->name('password.forget');

// Admin
Route::prefix('admin')->middleware(['role:admin|doctor|pharmacy'])->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->middleware('auth');
    Route::get('dashboard', DashboardController::class)->middleware(['auth', 'role:admin'])->name('dashboard');
});