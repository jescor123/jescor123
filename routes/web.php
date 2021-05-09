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

Route::get('/', 'ApiController@newsapi');
Route::post('modifyNew', 'ApiController@updateNew')->name('news.update');
Route::post('shareOnFb', 'ApiController@shareNewOnFacebook')->name('news.shareOnFacebook');
Route::post('/source_id', 'ApiController@newsapi');
Route::get('sendToFB', 'ApiController@sendNewToFacebook');



