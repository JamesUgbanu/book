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
$version = 'v1';

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/external-books', 'ApiController@getExternalBook');
Route::get($version.'/books', 'ApiController@getAllBooks');
Route::get($version.'/books/{id}', 'ApiController@getBook');
Route::post($version.'/books', 'ApiController@addBook');
Route::put($version.'/books/{id}', 'ApiController@updateBook');
Route::delete($version.'/books/{id}','ApiController@deleteBook');