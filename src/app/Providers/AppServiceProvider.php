<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // ユーザー登録サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\UserRegisterServiceInterface::class,
            \App\Services\Api\UserRegisterService::class
        );
        // ユーザーログインサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\UserLoginServiceInterface::class,
            \App\Services\Api\UserLoginService::class
        );
        // バインダー一覧情報取得サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderListSelectServiceInterface::class,
            \App\Services\Api\BinderListSelectService::class
        );
        // バインダー作成サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderCreateServiceInterface::class,
            \App\Services\Api\BinderCreateService::class
        );
        // バインダー情報取得サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderDetailSelectServiceInterface::class,
            \App\Services\Api\BinderDetailSelectService::class
        );
        // バインダーお気に入りサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderFavoriteServiceInterface::class,
            \App\Services\Api\BinderFavoriteService::class
        );
        // 画像追加サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\ImageAddServiceInterface::class,
            \App\Services\Api\ImageAddService::class
        );
        // 画像検索サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\ImageSearchServiceInterface::class,
            \App\Services\Api\ImageSearchService::class
        );
        // ラベル保存サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\LabelSaveServiceInterface::class,
            \App\Services\Api\LabelSaveService::class
        );
        // ラベリングサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\LabelingServiceInterface::class,
            \App\Services\Api\LabelingService::class
        );
    }
    

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
