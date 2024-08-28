<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KintaiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OptionController;
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

Route::get('/register', [OptionController::class, 'options'])
    ->name('register');

// 管理者ログイン・新規登録
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])
    ->name('admin.login');

Route::post('/admin/login', [LoginController::class, 'adminLogin'])
    ->name('admin.logged_in');

Route::group(['middleware' => ['auth:admin']], function () {

    Route::get('/admin/register', [RegisterController::class, 'showAdminRegisterForm'])
        ->name('admin.register');

    Route::post('/admin/register', [RegisterController::class, 'registerAdmin']);

    Route::post('/admin/logout', [LoginController::class, 'logout'])
        ->name('admin.logout');

    // 管理者用ページ
    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.index');

    Route::get('/admin/{id}', [AdminController::class,'show'])
        ->name('admin.show')
        ->where('id','[0-9]+');

    Route::get('/admin/{id}/edit', [AdminController::class,'edit'])
        ->name('admin.edit')
        ->where('id','[0-9]+');

    Route::patch('/admin/{id}/update', [AdminController::class,'update'])
        ->name('admin.update')
        ->where('id','[0-9]+');

    Route::get('/admin/{id}/change', [AdminController::class,'passwordForm'])
        ->name('admin.pass_form')
        ->where('id','[0-9]+');

    Route::patch('/admin/{id}/change', [AdminController::class,'changePassword'])
        ->name('admin.change_pass')
        ->where('id','[0-9]+');

    Route::post('/admin/add/store', [OptionController::class, 'store'])
        ->name('options.store');

    Route::delete('/admin/location_destroy/{id}', [OptionController::class, 'locationDestroy'])
        ->name('options.locationDestroy')
        ->where('id','[0-9]+');

    Route::delete('/admin/condition_destroy/{id}', [OptionController::class, 'conditionDestroy'])
        ->name('options.conditionDestroy')
        ->where('id','[0-9]+');
});


// マイページ
Route::get('/user/{id}', [UserController::class,'show'])
    ->name('user.show')
    ->where('id','[0-9]+');

Route::get('/user/{id}/edit', [UserController::class,'edit'])
    ->name('user.edit')
    ->where('id','[0-9]+');

Route::patch('/user/{id}/update', [UserController::class,'update'])
    ->name('user.update')
    ->where('id','[0-9]+');

Route::get('/user/{id}/change', [UserController::class,'passwordForm'])
    ->name('user.pass_form')
    ->where('id','[0-9]+');

Route::patch('/user/{id}/change', [UserController::class,'changePassword'])
    ->name('user.change_pass')
    ->where('id','[0-9]+');


// 勤怠登録
Route::get('/', [KintaiController::class,'create'])
    ->name('kintais.create');

Route::post('/kintais/store', [KintaiController::class,'store'])
    ->name('kintais.store');

Route::get('/kintais/{id}/stamp', [KintaiController::class,'stamp'])
    ->name('kintais.stamp')
    ->where('id','[0-9]+');

Route::patch('/kintais/{id}/add', [KintaiController::class,'add'])
    ->name('kintais.add')
    ->where('id','[0-9]+');

Route::get('/kintais/{userId}/show', [KintaiController::class,'show'])
    ->name('kintais.show')
    ->where('userId','[0-9]+');

Route::get('/kintais/{id}/edit', [KintaiController::class,'edit'])
    ->name('kintais.edit')
    ->where('id','[0-9]+');

Route::patch('/kintais/{id}/update', [KintaiController::class,'update'])
    ->name('kintais.update')
    ->where('id','[0-9]+');
