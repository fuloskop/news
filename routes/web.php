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
})->name('home');

Route::get('register', 'Auth\RegistrationController@index')->name('register.index');
Route::post('register', 'Auth\RegistrationController@store')->name('register.store');
Route::get('login', 'Auth\LoginController@index')->name('login.index');
Route::post('login', 'Auth\LoginController@login')->name('login');
