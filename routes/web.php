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
    return view('auth.login');
});

Route::prefix('admin')->group(function () {

    //group route with middleware "auth"
    Route::group(['middleware' => 'auth'], function() {

        //route dashboard
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard.index');

        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile.index');

        Route::resource('/user', \App\Http\Controllers\Admin\UserController::class, ['except' => ['show'], 'as' => 'admin']);

        Route::resource('/karyawan', \App\Http\Controllers\Admin\KaryawanController::class, ['except' => ['show'], 'as' => 'admin']);

        Route::get('/download{id}', [\App\Http\Controllers\Admin\KaryawanController::class, 'download'])->name('admin.download.index');
    });
});
