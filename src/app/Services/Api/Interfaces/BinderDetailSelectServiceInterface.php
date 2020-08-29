<?php

namespace App\Services\Api\Interfaces;

/**
 * バインダー一覧情報取得サービス
 */
interface BinderDetailSelectServiceInterface
{
    /**
     * 指定したバインダーIDを持つバインダーの詳細情報を取得します。
     *
     * @param string $binder_id
     * @return IlluminateHttpResponse
     */
    public function execute(string $binder_id);
}