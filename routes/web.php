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

Route::get('/mails', 'HomeController@index')->name('home');
Route::get('/mails/inspect/{id}', 'HomeController@inspect')->name('inspect');
Route::get('api/supporters', 'ApiController@supporters')->name('apiSupp');
Route::post('/home/addOrga', 'HomeController@addSupporterOrga')->name('addSupporterOrga');
Route::post('/home/addPers', 'HomeController@addSupporterPerson')->name('addSupporterPerson');
Route::post('/home/decline', 'HomeController@declineSupporter')->name('declineSupporter');

