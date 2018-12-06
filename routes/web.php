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

Route::get('/', [
    'uses' => 'PageController@index',
    'as' => 'homepage'
]);

Auth::routes();

Route::get('/home', 'PageController@index')->name('home');

Route::get('/cari', [
   'uses' => 'PageController@index',
   'as' => 'cari'
]);

Route::get('/login', [
   'uses' => 'PageController@showLoginForm',
   'as' => 'login'
]);

Route::get('/dashboard', [
    'uses' => 'PageController@showDashboard',
    'as' => 'user.dashboard'
]);

Route::get('tambah', [
    'uses' => 'PageController@tambahTambalBan',
    'as' => 'user.tambal-ban.tambah'
]);

Route::post('tambah-proses', [
    'uses' => 'TambalBanController@tambahTambalBan',
    'as' => 'user.tambal-ban.tambah.proses'
]);

Route::get('detail-tempat', [
    'uses' => 'PageController@showDetail',
    'as' => 'detail-tempat'
]);

Route::get('detail-rute', [
    'uses' => 'PageController@showDetailRute',
    'as' => 'detail-tempat.route'
]);

Route::namespace('Auth')->group(function () {
    Route::post('/login', [
        'uses' => 'LoginController@authenticate',
        'as' => 'login.proses'
    ]);
});