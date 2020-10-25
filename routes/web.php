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

Route::get('/', 'HomeController@index')->name('index');

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false
]);

Route::get('/logout', 'Auth\LoginController@logout')->name('logout-get');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/{id}/edit', 'HomeController@edit')
        ->where(['id' => '[0-9]+'])
        ->name('edit');
    Route::get('/{id}/delete', 'HomeController@delete')
        ->where(['id' => '[0-9]+'])
        ->name('delete');
    Route::post('/', 'HomeController@store')
        ->name('index-post');
    Route::post('/{id}/edit', 'HomeController@update')
        ->name('update');
    Route::post('/{id}/delete', 'HomeController@indexdelete')
        ->name('index-delete');
});
