<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use App\Http\Requests\BinderFavoriteRequest;

/**
 * バインダーお気に入りサービス
 */
interface BinderFavoriteServiceInterface
{
    /**
     * バインダーをお気に入りに追加します。
     *
     * @param BinderFavoriteRequest $request
     */
    public function execute(BinderFavoriteRequest $request);
}