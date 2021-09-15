<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** Регистрация нового пользователя */
Route::post('registration', 'Users\Authorization@registration');

/** Авторизация пользователя и выдача токена */
Route::post('login', 'Users\Authorization@login');

/** Маршрутизаяция авторизированного пользователя */
Route::middleware('auth:sanctum')->group(function() {

    /** Выход пользователя и отзыв токена */
    Route::post('logout', 'Users\Authorization@logout');

    /** Данные пользователя */
    Route::post('user', function (Request $request) {
        return $request->user();
    });

});
