<?php

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

Route::get('/',                                     \App\Http\Controllers\HomeController::class);

Route::group( ['middleware' => 'auth'], function() {

    Route::get('home',                              \App\Http\Controllers\HomeController::class)->name('home');

    Route::get('media/{media}',                     [\App\Http\Controllers\MediaController::class, 'show']);

    Route::prefix('users/profile')->group(function() {
        Route::get('/{user}',                       [\App\Http\Controllers\UserProfileController::class, 'show']);
        Route::patch('/{user}',                     [\App\Http\Controllers\UserProfileController::class, 'update']);
    });

    Route::group(['prefix'=>'users/tfa'],function () {
        Route::delete('/{user}',                    [\App\Http\Controllers\User2FAController::class, 'destroy']);
    });

    Route::prefix('settings')->group(function() {
        Route::get('edit/{settings}',               [\App\Http\Controllers\SettingController::class, 'edit']);
        Route::patch('/{settings}',                 [\App\Http\Controllers\SettingController::class, 'update']);
    });

});

Route::get('/{url}',                                [\App\Http\Controllers\ErrorController::class, 'lost'])
    ->where(['url' => 'wp-admin|wp-login.php']);
