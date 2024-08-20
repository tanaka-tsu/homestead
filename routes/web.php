<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KintaiController;

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

Route::get('/', [KintaiController::class,'create'])
    ->name('create.kintais');

Route::post('/kintais/store', [KintaiController::class,'store'])
    ->name('store.kintais');

Route::get('/kintais/{id}/stamp', [KintaiController::class,'stamp'])
    ->name('stamp.kintais')
    ->where('id','[0-9]+');

Route::patch('/kintais/{id}/update', [KintaiController::class,'update'])
    ->name('update.kintais')
    ->where('id','[0-9]+');

Route::get('/kintais/{userId}/show', [KintaiController::class,'show'])
    ->name('show.kintais')
    ->where('userId','[0-9]+');

Route::get('/kintais/{id}/edit', [KintaiController::class,'edit'])
    ->name('edit.kintais')
    ->where('id','[0-9]+');

Route::patch('/kintais/{id}/revision', [KintaiController::class,'revision'])
    ->name('revision.kintais')
    ->where('id','[0-9]+');
