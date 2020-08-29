<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // ユーザーリポジトリ
        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );
        // バインダーリポジトリ
        $this->app->bind(
            \App\Repositories\Interfaces\BinderRepositoryInterface::class,
            \App\Repositories\BinderRepository::class
        );
        // 画像リポジトリ
        $this->app->bind(
            \App\Repositories\Interfaces\ImageRepositoryInterface::class,
            \App\Repositories\ImageRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
