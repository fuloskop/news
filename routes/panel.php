<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Panel API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Panel API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Panel API" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth','prefix' => 'api/v1'], function () {
    Route::group(['middleware' => ['role:admin|moderator']] , function () {
        Route::post('/setrole', 'Admin\AdminController@updateRoles')->name('api.setrole');
    });
});

