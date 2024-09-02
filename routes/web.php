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
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');

Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'showAdminLoginForm'])
        ->name('admin.login');

    Route::post('login', [LoginController::class, 'adminLogin'])
        ->name('admin.logged_in');

    // ログイン以外のadminルートはauth:adminを適用
    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('register', [RegisterController::class, 'showAdminRegisterForm'])
            ->name('admin.register');

        Route::post('register', [RegisterController::class, 'registerAdmin']);

        Route::post('logout', [LoginController::class, 'logout'])
            ->name('admin.logout');

        Route::get('', [AdminController::class, 'index'])
            ->name('admin.index');

        Route::get('{id}', [AdminController::class,'show'])
            ->name('admin.show')
            ->where('id','[0-9]+');

        Route::get('{id}/edit', [AdminController::class,'edit'])
            ->name('admin.edit');

        Route::patch('{id}/update', [AdminController::class,'update'])
            ->name('admin.update');

        Route::get('{id}/change', [AdminController::class,'passwordForm'])
            ->name('admin.pass_form');

        Route::patch('{id}/change', [AdminController::class,'changePassword'])
            ->name('admin.change_pass');

        Route::get('add', [OptionController::class, 'index'])
            ->name('options.index');

        Route::post('add/store', [OptionController::class, 'store'])
            ->name('options.store');

        Route::delete('location_destroy/{id}', [OptionController::class, 'locationDestroy'])
            ->name('options.locationDestroy');

        Route::delete('condition_destroy/{id}', [OptionController::class, 'conditionDestroy'])
            ->name('options.conditionDestroy');

});


// マイページ
Route::prefix('user')->group(function () {
    Route::get('{id}', [UserController::class,'show'])
        ->name('user.show')
        ->where('id','[0-9]+');

    Route::get('{id}/edit', [UserController::class,'edit'])
        ->name('user.edit');

    Route::patch('{id}/update', [UserController::class,'update'])
        ->name('user.update');

    Route::get('{id}/change', [UserController::class,'passwordForm'])
        ->name('user.pass_form');

    Route::patch('{id}/change', [UserController::class,'changePassword'])
        ->name('user.change_pass');
});


// 勤怠登録
Route::get('/', [KintaiController::class,'create'])
    ->name('kintais.create');

Route::prefix('kintais')->group(function () {
    Route::post('store', [KintaiController::class,'store'])
        ->name('kintais.store');

    Route::get('{id}/stamp', [KintaiController::class,'stamp'])
        ->name('kintais.stamp');

    Route::patch('{id}/add', [KintaiController::class,'add'])
        ->name('kintais.add');

    Route::get('{id}/edit', [KintaiController::class,'edit'])
        ->name('kintais.edit');

    Route::patch('{id}/update', [KintaiController::class,'update'])
        ->name('kintais.update');

    Route::get('{model}/{id}', [KintaiController::class,'show'])
        ->name('kintais.show')
        ->where('id','[0-9]+');
});
