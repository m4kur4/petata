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
     * バインダーのお気に入り設定を切り替えます。
     * ログインユーザーが当該バインダーをお気に入り登録していない場合は新たに登録し、
     * すでにお気に入り登録されている場合は解除します。
     *
     * @param BinderFavoriteRequest $request
     */
    public function execute(BinderFavoriteRequest $request);
}