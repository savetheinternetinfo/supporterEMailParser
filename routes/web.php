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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('api/supporters', 'ApiController@supporters')->name('apiSupp');
Route::post('/home/addOrga', 'HomeController@addSupporterOrga')->name('addSupporterOrga');
Route::post('/home/addPers', 'HomeController@addSupporterPerson')->name('addSupporterPerson');
Route::post('/home/descline', 'HomeController@declineSupporter')->name('declineSupporter');

