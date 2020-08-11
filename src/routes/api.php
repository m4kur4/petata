<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ユーザー登録
Route::post('user/register','Auth\RegisterController@register')->name('user.register');

// TEST: 外部リソース取得
Route::post('document/html', 'Front\DocumentController@getRawHtml')->name('api.document.html');
