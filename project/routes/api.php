<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompilationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name('api.auth.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('api.auth.logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('compilations')->group(function () {
        Route::get('/get-actual', [CompilationsController::class, 'getActual'])->name('api.compilations.get-actual');
        Route::put('/complete-exercise/{id}', [CompilationsController::class, 'completeExercise'])->name('api.compilations.complete-exercise');
        Route::put('/replace-exercise/{id}', [CompilationsController::class, 'replaceExercise'])->name('api.compilations.replace-exercise');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
