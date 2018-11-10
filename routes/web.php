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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::resource('/api/v1/verifier', 'ApiFisherController');
Route::resource('/fake', 'FakeNewsController');
Route::get('/home', 'HomeController@index')->name('home');
