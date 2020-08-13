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
            \App\Services\Api\Interfaces\UserRegistrationServiceInterface::class,
            \App\Services\Api\UserRegistrationService::class
        );
        // ユーザー認証サービス
        $this->app->bind(
            \App\Services\Api\Interfaces\UserAuthorizationServiceInterface::class,
            \App\Services\Api\UserAuthorizationService::class
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
