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

Route::get('/home', function () {
    return view('welcome');
})->name('homepage');

Route::get('/', function () {
    return view('frontend.home');
})->name('home');



Route::get('test', 'TestController@test');

Route::group(['middleware' => 'guest'], function () {
    Route::get('register', 'Auth\RegistrationController@index')->name('register.index');
    Route::post('register', 'Auth\RegistrationController@store')->name('register.store');
    Route::get('login', 'Auth\LoginController@index')->name('login.index');
    Route::post('login', 'Auth\LoginController@login')->name('login');
});

Route::post('/setrole', 'Admin\AdminController@updateRoles')->name('api.setrole');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout','Auth\LoginController@logout')->name('logout');

    Route::prefix('admin')->group(function () {
        Route::get('/', 'Admin\AdminController@getAdminPanel')->name('AdminPanel');
        Route::get('/roles', 'Admin\AdminController@changeRoles')->name('AdminRoles');
    });
});

