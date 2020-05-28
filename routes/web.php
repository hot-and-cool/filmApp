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

Route::get('/', 'FilmController@index')->name('index');
Route::get('/mypage', 'FilmController@showMypage')->name('mypage');
Route::get('/{id}', 'FilmController@show')->name('show');
Route::get('/credit/{person_id}', 'FilmController@showPersonPage')->name('person');
Route::post('/{id}/clip','FilmController@storeClip')->name('clip');

