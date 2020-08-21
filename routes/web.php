<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;

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

Auth::routes();

Route::get('/', [ThreadController::class, 'index'])->name('thread.index');
Route::get('/threads', [ThreadController::class, 'index'])->name('thread.index');
Route::get('/threads/create', [ThreadController::class, 'create'])->name('thread.create')->middleware('auth');
Route::post('/threads', [ThreadController::class, 'store'])->name('thread.store')->middleware('auth');

Route::get('/threads/{category}', [ThreadController::class, 'index']);
Route::get('/threads/{category}/{thread}', [ThreadController::class, 'show'])->name('thread.show');
Route::delete('/threads/{category}/{thread}', [ThreadController::class, 'destroy'])->name('thread.delete')->middleware('auth');

Route::post('/threads/{category}/{thread}/replies', [ReplyController::class, 'store'])->middleware('auth');

Route::post('/replies/{reply}/favorites', [FavoriteController::class, 'store'])->middleware('auth')->name('reply.favorite');

Route::get('/profiles/{user}', [ProfileController::class, 'show'])->name('profile');
