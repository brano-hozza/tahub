<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//postman
Route::get('csrf','PostmanController@index');

//auth
Route::post('token','ApiTokenController@update');

Route::post('regToken','Auth\RegisterController@createToken');

Route::post('login', 'Auth\LoginController@loginAPI');

Route::post('register', 'Auth\RegisterController@registerAPI');

//mess
Route::post('mess/send','MessageController@create');

Route::post('mess','MessageController@getMessages');

Route::post('mess/friends', 'MessageController@getFriends');

Route::post('mess/friends/add', 'MessageController@addFriend');


//cloud
Route::post('cloud/folders', 'CloudController@getFolders');

Route::post('cloud/files', 'CloudController@getFiles');

Route::post('cloud/folders/add', 'CloudController@addFolder');

Route::post('cloud/folders/delete', 'CloudController@removeFolder');

Route::post('cloud/files/add', 'CloudController@addFile');

Route::post('cloud/files/delete', 'CloudController@removeFile');

Route::post('cloud/files/download', 'CloudController@downloadFile');

