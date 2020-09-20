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

// ユーザーログアウト
Route::post('user/auth/logout','UserController@logout')->name('api.user.logout');

// パスワードリマインダーメール送信
Route::post('user/auth/reminder','UserController@remind')->name('api.user.reminder');

// パスワードリセット画面表示
Route::get('user/auth/password/reset','UserController@remind')->name('api.user.password.reset');

// バインダー一覧取得
Route::get('binder/list','BinderController@list')->name('api.binder.list');

// バインダー検索
Route::get('binder/search','BinderController@search')->name('api.binder.search');

// バインダー情報取得
Route::get('binder/detail/{binder_id}','BinderController@detail')->name('api.binder.detail');

// バインダー保存
Route::post('binder/save','BinderController@save')->name('api.binder.save');

// バインダーお気に入り設定
Route::post('binder/favorite','BinderController@favorite')->name('api.binder.favorite');

// バインダー削除
Route::post('binder/delete','BinderController@delete')->name('api.binder.delete');

// ラベリング登録
Route::post('binder/label/register','BinderController@labeling')->name('api.binder.image.labeling');

// ラベリング一括登録
Route::post('binder/label/register-multiple','BinderController@labelingMany')->name('api.binder.image.labeling.multiple');

// ラベル保存
Route::post('binder/label/save','BinderController@saveLabel')->name('api.binder.label.save');

// ラベル削除
Route::post('binder/label/delete','BinderController@deleteLabel')->name('api.binder.label.delete');

// ラベル並び順更新
Route::post('binder/label/sort','BinderController@sortLabel')->name('api.binder.label.sort');

// 画像追加
Route::post('binder/image/add', 'ImageController@add')->name('api.binder.image.add');

// 画像削除
Route::post('binder/image/delete', 'ImageController@delete')->name('api.binder.image.delete');

// 画像並び順更新
Route::post('binder/image/sort', 'ImageController@sort')->name('api.binder.image.sort');

// 画像リネーム
Route::post('binder/image/rename', 'ImageController@rename')->name('api.binder.image.rename');

// 画像検索
Route::get('binder/image/search', 'ImageController@search')->name('api.binder.image.search');

// 画像詳細
Route::get('binder/image/detail/{image_id}', 'ImageController@detail')->name('api.binder.image.detail');

// 画像ダウンロード
Route::get('binder/image/download', 'ImageController@download')->name('api.binder.image.download');

// TODO: ユーザー退会
//Route::post('user/unregister','Auth\RegisterController@register')->name('user.unregister');

// TEST: 外部リソース取得
Route::post('document/html', 'DocumentController@getRawHtml')->name('api.document.html');
