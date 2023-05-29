<?php

use App\Http\Controllers\Admin\Auth\ForgetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoignController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorsController;
use App\Http\Controllers\Admin\GovernoratesController;
use App\Http\Controllers\Admin\PharmaciesController;
use App\Http\Controllers\Admin\UsersController;

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
    // Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->middleware('auth');
    Route::get('dashboard', DashboardController::class)->middleware('auth')->name('dashboard');

    // Pharmacies
    Route::resource('pharmacies', PharmaciesController::class)->middleware(['auth', 'role:admin']);
    Route::get('export/pharmacies', [PharmaciesController::class, 'export'])->middleware(['auth', 'role:admin'])->name('pharmacies.export');

    // Users
    Route::resource('users', UsersController::class)->middleware(['auth', 'role:admin']);
    Route::get('export/users', [UsersController::class, 'export'])->middleware(['auth', 'role:admin'])->name('users.export');

    // Governorates
    Route::resource('governorates', GovernoratesController::class)->middleware(['auth', 'role:admin']);

    // Doctors
    Route::resource('doctors', DoctorsController::class)->middleware(['auth', 'role:admin|pharmacy']);
    Route::get('export/doctors', [DoctorsController::class, 'export'])->middleware(['auth', 'role:admin|pharmacy'])->name('doctors.export');
});