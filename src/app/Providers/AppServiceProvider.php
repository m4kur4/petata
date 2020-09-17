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
        // ユーザーログアウトサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\UserLogoutServiceInterface::class,
            \App\Services\Api\UserLogoutService::class
        );
        // バインダー一覧情報取得サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderListSelectServiceInterface::class,
            \App\Services\Api\BinderListSelectService::class
        );
        // バインダー検索サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderSearchServiceInterface::class,
            \App\Services\Api\BinderSearchService::class
        );
        // バインダー作成サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderSaveServiceInterface::class,
            \App\Services\Api\BinderSaveService::class
        );
        // バインダー削除サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\BinderDeleteServiceInterface::class,
            \App\Services\Api\BinderDeleteService::class
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
        // 画像削除サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\ImageDeleteServiceInterface::class,
            \App\Services\Api\ImageDeleteService::class
        );
        // 画像リネームサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\ImageRenameServiceInterface::class,
            \App\Services\Api\ImageRenameService::class
        );
        // 画像並び順更新サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\ImageSortServiceInterface::class,
            \App\Services\Api\ImageSortService::class
        );
        // 画像検索サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\ImageSearchServiceInterface::class,
            \App\Services\Api\ImageSearchService::class
        );
        // 画像ダウンロードサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\ImageDownloadServiceInterface::class,
            \App\Services\Api\ImageDownloadService::class
        );
        // ラベル保存サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\LabelSaveServiceInterface::class,
            \App\Services\Api\LabelSaveService::class
        );
        // ラベル削除サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\LabelDeleteServiceInterface::class,
            \App\Services\Api\LabelDeleteService::class
        );
        // ラベル並び順更新サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\LabelSortServiceInterface::class,
            \App\Services\Api\LabelSortService::class
        );
        // ラベリングサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\LabelingServiceInterface::class,
            \App\Services\Api\LabelingService::class
        );
        // 一括ラベリングサービス
        $this->app->bind(
            \App\Services\Api\Interfaces\MultipleLabelingServiceInterface::class,
            \App\Services\Api\MultipleLabelingService::class
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
