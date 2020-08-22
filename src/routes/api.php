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
Route::post('user/register','UserController@register')->name('api.user.register');

// ユーザーログイン
Route::post('user/auth/login','UserController@login')->name('api.user.login');

// バインダー作成
Route::post('binder/create','BinderController@create')->name('api.binder.create');

// TODO: ユーザー退会
//Route::post('user/unregister','Auth\RegisterController@register')->name('user.unregister');

// TEST: 外部リソース取得
Route::post('document/html', 'DocumentController@getRawHtml')->name('api.document.html');
