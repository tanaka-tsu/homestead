<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KintaiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;

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

// 管理者ログイン・新規登録
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])
    ->name('login.admin');

Route::post('/admin/login', [LoginController::class, 'adminLogin'])
    ->name('loggedIn.admin');

Route::group(['middleware' => ['auth:admin']], function () {

    Route::get('/admin/register', [RegisterController::class, 'showAdminRegisterForm'])
        ->name('register.admin');

    Route::post('/admin/register', [RegisterController::class, 'registerAdmin']);

    Route::post('/admin/logout', [LoginController::class, 'logout'])
        ->name('logout.admin');

    // 管理者用ページ
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('index.admin');

    Route::get('/admin/{id}', [AdminController::class,'show'])
        ->name('show.admin')
        ->where('id','[0-9]+');

    Route::get('/admin/{id}/edit', [AdminController::class,'edit'])
        ->name('edit.admin')
        ->where('id','[0-9]+');

    Route::patch('/admin/{id}/update', [AdminController::class,'update'])
        ->name('update.admin')
        ->where('id','[0-9]+');

    Route::get('/admin/{id}/change', [AdminController::class,'passwordForm'])
        ->name('passwordForm.admin')
        ->where('id','[0-9]+');

    Route::patch('/admin/{id}/change', [AdminController::class,'changePassword'])
        ->name('changePassword.admin')
        ->where('id','[0-9]+');
});


// マイページ
Route::get('/user/{id}', [UserController::class,'show'])
    ->name('show.user')
    ->where('id','[0-9]+');

Route::get('/user/{id}/edit', [UserController::class,'edit'])
    ->name('edit.user')
    ->where('id','[0-9]+');

Route::patch('/user/{id}/update', [UserController::class,'update'])
    ->name('update.user')
    ->where('id','[0-9]+');

Route::get('/user/{id}/change', [UserController::class,'passwordForm'])
    ->name('passwordForm.user')
    ->where('id','[0-9]+');

Route::patch('/user/{id}/change', [UserController::class,'changePassword'])
    ->name('changePassword.user')
    ->where('id','[0-9]+');


// 勤怠登録
Route::get('/', [KintaiController::class,'create'])
    ->name('create.kintais');

Route::post('/kintais/store', [KintaiController::class,'store'])
    ->name('store.kintais');

Route::get('/kintais/{id}/stamp', [KintaiController::class,'stamp'])
    ->name('stamp.kintais')
    ->where('id','[0-9]+');

Route::patch('/kintais/{id}/add', [KintaiController::class,'add'])
    ->name('add.kintais')
    ->where('id','[0-9]+');

Route::get('/kintais/{userId}/show', [KintaiController::class,'show'])
    ->name('show.kintais')
    ->where('userId','[0-9]+');

Route::get('/kintais/{id}/edit', [KintaiController::class,'edit'])
    ->name('edit.kintais')
    ->where('id','[0-9]+');

Route::patch('/kintais/{id}/update', [KintaiController::class,'update'])
    ->name('update.kintais')
    ->where('id','[0-9]+');
