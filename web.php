<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailViewController;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\RespostaViewController;

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
    return view('welcome');
});

Route::get('/', [AuthController::class, 'loginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.post');
Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/emails', [EmailViewController::class, 'index'])->name('emails.index');
Route::get('/emails/create', [EmailViewController::class, 'create'])->name('emails.create');
Route::get('/emails/{id}', [EmailViewController::class, 'show'])->name('emails.show');
Route::post('/emails', [EmailViewController::class, 'store'])->name('emails.store');
Route::get('/admin/dashboard', [AdminViewController::class, 'index'])->name('admin.dashboard');
Route::post('/respostas', [RespostaViewController::class, 'store'])->name('respostas.store');
