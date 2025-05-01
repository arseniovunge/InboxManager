<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UtilizadorController;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\AnexoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RespostaController;
use App\Http\Controllers\Api\AdminController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('utilizadores', UtilizadorController::class);
Route::apiResource('emails', EmailController::class);
Route::apiResource('anexos', AnexoController::class);
Route::post('/registar', [AuthController::class, 'registar']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verificar-codigo', [AuthController::class, 'verificarCodigo']);
Route::apiResource('respostas', RespostaController::class);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/utilizadores/{id}/relatorio', [AdminController::class, 'gerarRelatorio']);

