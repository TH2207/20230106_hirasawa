<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::get('/', [TodoController::class, 'index'])->middleware('auth');
// Route::post('/find', [TodoController::class, 'find'])->middleware('auth');
// Route::post('/search', [TodoController::class, 'search'])->name('search');
Route::post('/create', [TodoController::class, 'create'])->name('create');
Route::post('/update', [TodoController::class, 'update'])->name('update');
Route::post('/remove', [TodoController::class, 'remove'])->name('remove');

Route::get('/dashboard', [TodoController::class, 'login']);
Route::get('/register', [RegisteredUserController::class, 'create']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

Route::post('/find', [TodoController::class, 'find'])->middleware('auth');
Route::post('/search', [TodoController::class, 'search'])->name('search');

require __DIR__.'/auth.php';
