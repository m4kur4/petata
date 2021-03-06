<?php

namespace App\Services\Api\Interfaces;

/**
 * バインダー一覧情報取得サービス
 */
interface BinderListSelectServiceInterface
{
    /**
     * 指定したユーザーIDにアクセス権限が付与されているバインダーの一覧情報を取得します。
     *
     * @param string $user_id
     * @return IlluminateHttpResponse
     */
    public function execute(string $user_id);
}