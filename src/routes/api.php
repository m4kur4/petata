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

// ログインユーザー情報取得
Route::get('user/info', 'UserController@getLoginUser')->name('api.user.info');

// ユーザー登録
Route::post('user/register','UserController@register')->name('api.user.register');

// ユーザーログイン
Route::post('user/auth/login','UserController@login')->name('api.user.login');

// バインダー作成
Route::post('binder/create','BinderController@create')->name('api.binder.create');

// ラベル保存
Route::post('binder/label/save','BinderController@saveLabel')->name('api.binder.label.save');

// バインダー一覧取得
Route::get('binder/list','BinderController@list')->name('api.binder.list');

// バインダー情報取得
Route::get('binder/detail/{binder_id}','BinderController@detail')->name('api.binder.detail');

// 画像追加 NOTE: Dropzone.jsの仕様(?)で呼び出しページのURLが先頭に付与される
Route::post('image/add', 'ImageController@add')->name('api.image.add');

// TODO: ユーザー退会
//Route::post('user/unregister','Auth\RegisterController@register')->name('user.unregister');

// TEST: 外部リソース取得
Route::post('document/html', 'DocumentController@getRawHtml')->name('api.document.html');
