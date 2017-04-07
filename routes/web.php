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


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index');

// Telegram
Route::get('telegram/update', 'TelegramController@getUpdates');
Route::get('telegram/send',  'TelegramController@getSendMessage');
Route::post('telegram/send', 'TelegramController@postSendMessage');
// Route Telegram & Save Mober - Adser
Route::post('noapi/telegram/ajax/{mober?}', 'TelegramController@postSendAjax');