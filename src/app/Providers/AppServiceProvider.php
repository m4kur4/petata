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
