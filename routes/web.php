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

    Route::prefix('client-types')->group(function() {
        Route::get('/',                             [\App\Http\Controllers\ClientTypeController::class, 'index']);
        Route::get('create',                        [\App\Http\Controllers\ClientTypeController::class, 'create']);
        Route::post('/',                            [\App\Http\Controllers\ClientTypeController::class, 'store']);
        Route::get('show/{clientType}',             [\App\Http\Controllers\ClientTypeController::class, 'show']);
        Route::get('edit/{clientType}',             [\App\Http\Controllers\ClientTypeController::class, 'edit']);
        Route::patch('/{clientType}',               [\App\Http\Controllers\ClientTypeController::class, 'update']);
        Route::delete('/{clientType}',              [\App\Http\Controllers\ClientTypeController::class, 'destroy']);
    });

    Route::prefix('clients')->group(function() {
        Route::get('show/{client}',                 [\App\Http\Controllers\ClientController::class, 'show']);
        Route::get('edit/{client}',                 [\App\Http\Controllers\ClientController::class, 'edit']);
    });

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
