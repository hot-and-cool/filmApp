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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'ReviewController@index')->name('index');
Route::get('/{id}', 'ReviewController@show')->name('show');
Route::get('/credit/{person_id}', 'ReviewController@credit')->name('credit');


