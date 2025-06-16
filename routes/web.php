<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
Route::get('/', function () {

    // return redirect()->route('usuario.dashboard');
})->middleware('auth')->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/usuario', [UserController::class, 'index'])
        ->name('usuario.perfil');
    Route::put('/perfil/update', [UserController::class, 'update'])->name('perfil.update');
    Route::get('/perfil/senha', [UserController::class, 'showPasswordForm'])->name('perfil.senha.form');
    Route::put('/perfil/senha', [UserController::class, 'updatePassword'])->name('perfil.senha.update');

    Route::get('/usuario/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

Route::get('auth/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('auth/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('auth/login', [LoginController::class, 'login'])->name('login.attempt');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
