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





Route::get('test', 'TestController@test');

Route::group(['middleware' => 'guest'], function () {
    Route::get('register', 'Auth\RegistrationController@index')->name('register.index');
    Route::post('register', 'Auth\RegistrationController@store')->name('register.store');
    Route::get('login', 'Auth\LoginController@index')->name('login.index');
    Route::post('login', 'Auth\LoginController@login')->name('login');
});

//Route::post('/setrole', 'Admin\AdminController@updateRoles')->name('api.setrole');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('frontend.home');
    })->name('home');

    Route::get('/logout','Auth\LoginController@logout')->name('logout');
    Route::get('/delaccount', 'DeleteAccountRequestController@create')->name('create.delacount');
    Route::post('/delaccount', 'DeleteAccountRequestController@store')->name('store.delacount');

    Route::group(['prefix' => 'editor','middleware' => ['can:access editor panel']], function () {
        Route::get('', 'Editor\EditorController@getEditorPanel')->name('EditorPanel');
        Route::get('createnews', 'Editor\EditorController@createnews')->name('Editor.createnews');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['role:admin|moderator']] , function () {
        Route::get('', 'Admin\AdminController@getAdminPanel')->name('AdminPanel');
        Route::get('roles', 'Admin\AdminController@changeRoles')->name('AdminRoles');
        Route::get('deleterequests', 'Admin\AdminController@AdminAcctDelReqIndex')->name('AdminAcctDelReqIndex');
        Route::get('deleterequests/{id}', 'Admin\AdminController@AdminAcctDelReqShow')->name('AdminAcctDelReqShow');
        Route::post('deleterequests/{id}', 'Admin\AdminController@AdminAcctDelReqUpdate')->name('AdminAcctDelReqUpdate');
        //getAdminChangeEditorCategoriesPage
        Route::get('changeeditorcateg', 'Admin\AdminController@getAdminChangeEditorCategoriesPage')->name('AdminChangeEditorCateg.index');
        Route::get('changeeditorcateg/{id}', 'Admin\AdminController@AdminChangeEditorCategoriesShow')->name('AdminChangeEditorCateg.show');
    });
});

