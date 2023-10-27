<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/record', [App\Http\Controllers\AttendanceController::class, 'show'])->name('record');

Route::post('/begin_work', [App\Http\Controllers\AttendanceController::class, 'beginWork'])->name('begin_work');

Route::post('/finish_work', [App\Http\Controllers\AttendanceController::class, 'finishWork'])->name('finish_work');
