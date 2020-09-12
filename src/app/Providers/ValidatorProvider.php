<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

/**
 * カスタムバリデーションプロバイダ
 * 
 * 独自のバリデーションをここに定義する。
 * バリデーション名にはカスタマイズ版と分かるように「c_」を頭に付けること。
 */
class ValidatorProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 半角英字チェック
        Validator::extend('c_alpha', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[A-Za-z]+$/', $value);
        });

        // 半角英字＋スペースチェック
        Validator::extend('c_alpha_sp', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[A-Za-z\s]+$/', $value);
        });

        // 半角英数字チェック
        Validator::extend('c_alpha_num', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[A-Za-z\d_\-]+$/', $value);
        });

        // 半角数字＋スペースチェック
        Validator::extend('c_num_sp', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9\s]+$/', $value);
        });

        // ファイルフォーマットチェック（画像 or PDF）
        Validator::extend('image_or_pdf', function ($attribute, $value, $parameters, $validator) {
            return (\File::extension($value) == '');
        });

        // 半角数字
        Validator::extend('c_num', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]+$/', $value);
        });
    }
}
