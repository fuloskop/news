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
   /* Route::get('/', function () {
        return view('frontend.home');
    })->name('home');
   */

    Route::post('ckeditor/upload', 'CKEditorController@upload')->name('ckeditor.image-upload');

    Route::get('/logout','Auth\LoginController@logout')->name('logout');
    Route::get('/delaccount', 'DeleteAccountRequestController@create')->name('create.delacount');
    Route::post('/delaccount', 'DeleteAccountRequestController@store')->name('store.delacount');

    Route::get('/', 'HomePage\NewsController@getAllPublishNews')->name('home');
    Route::get('/specialnews', 'HomePage\NewsController@getNewsBySubCategories')->name('specialnews');
    Route::get('/news/{id}', 'HomePage\NewsController@getNewsById')->name('News.show');
    Route::get('/categories','HomePage\NewsController@getAllCategories')->name('IndexCategories');
    Route::get('/category/{id}','HomePage\NewsController@getNewsByCategoryId')->name('News.IndexByCategory');

    Route::post('/comment','HomePage\CommentController@store')->name('Comment.store');
    Route::get('/comment/{id}','HomePage\CommentController@destroy')->name('Comment.destroy');

    Route::group(['prefix' => 'editor','middleware' => ['role:admin|moderator|editor']], function () {
        Route::get('', 'Editor\EditorController@getEditorPanel')->name('EditorPanel');
        Route::get('indexnews', 'Editor\EditorController@indexnews')->name('Editor.indexnews');
        Route::get('createnews', 'Editor\EditorController@createnews')->name('Editor.createnews');
        Route::post('storenews', 'Editor\EditorController@storenews')->name('Editor.storenews');
        Route::get('editenews/{id}', 'Editor\EditorController@editnews')->name('Editor.editenews');
        Route::post('editenews/{id}', 'Editor\EditorController@updatenews')->name('Editor.updatenews');
        Route::get('destroynews/{id}', 'Editor\EditorController@destroynews')->name('Editor.destroynews');
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
        Route::get('indexcategory', 'Admin\AdminController@indexCategory')->name('Category.index');
        Route::get('createcategory', 'Admin\AdminController@createCategory')->name('Category.create');
        Route::post('storecategory', 'Admin\AdminController@storeCategory')->name('Category.store');
        Route::get('editcategory/{id}', 'Admin\AdminController@editCategory')->name('Category.edit');
        Route::post('editcategory/{id}', 'Admin\AdminController@updateCategory')->name('Category.update');
        Route::get('destroycategory/{id}', 'Admin\AdminController@destroyCategory')->name('Category.destroy');
        Route::get('indexlogs', 'Admin\AdminController@getAllLogs')->name('Logs.index');
        Route::get('indexactivities', 'Admin\AdminController@getAllActivities')->name('Activities.index');
    });
});

