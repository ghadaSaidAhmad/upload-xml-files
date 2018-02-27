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

Route::get('/','MyFileController@index');
Route::get('myfiles/{id}/delete','MyFileController@destroy');
Route::post('/fetchRows','MyFileController@fetchRows');
Route::post('/deleteRow','MyFileController@deleteRow');
Route::post('/updateRow','MyFileController@updateRow');
Route::post('/insertRow','MyFileController@insertRow');

Route::resource('myfiles','MyFileController');
