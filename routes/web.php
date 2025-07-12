<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\PositionController;
use App\Http\Controllers\Dashboard\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard\UserPositionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');
Route::post('/positions', [PositionController::class, 'store']);
Route::delete('/positions/{uuid}', [PositionController::class, 'destroy']);
Route::put('/positions/{uuid}', [PositionController::class, 'update']);
Route::post('/user-positions', [UserPositionController::class, 'store']);

Route::post('/tasks', [TaskController::class, 'store']);
Route::delete('/tasks/{uuid}', [TaskController::class, 'destroy']);
Route::put('/tasks/{uuid}', [TaskController::class, 'update']);
// require __DIR__.'/auth.php';
