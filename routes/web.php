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

Route::get('edit', [
    'uses' => 'PageController@editTambalBan',
    'as' => 'user.tambal-ban.edit'
]);

Route::post('tambah-proses', [
    'uses' => 'TambalBanController@tambahTambalBan',
    'as' => 'user.tambal-ban.tambah.proses'
]);

Route::post('tambah-galeri-proses', [
    'uses' => 'TambalBanController@tambahGaleri',
    'as' => 'user.galeri.tambah.proses'
]);

Route::get('get-gambar/{path}', [
    'uses' => 'PageController@getGambar',
    'as' => 'user.get-gambar'
]);

Route::get('get-geocode', [
   'uses' => 'GeocodeSearch@action',
   'as' => 'get-geocode'
]);

Route::get('get-reverse-geocode', [
    'uses' => 'ReverseGeocodeSearch@action',
    'as' => 'get-reverse-geocode'
]);

Route::post('tambah-banyak-proses', [
    'uses' => 'TambalBanController@tambahBanyak',
    'as' => 'user.tambal-ban.tambah-banyak.proses'
]);

Route::post('update-proses', [
    'uses' => 'TambalBanController@updateTambalBan',
    'as' => 'user.tambal-ban.update.proses'
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
    Route::post('/login-proses', [
        'uses' => 'LoginController@authenticate',
        'as' => 'login.proses'
    ]);
    Route::get('/logout-proses', [
        'uses' => 'LoginController@logout',
        'as' => 'logout.proses'
    ]);
});
