<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\BinderDeleteRequest;

/**
 * バインダー一覧情報取得サービス
 */
interface BinderDeleteServiceInterface
{
    /**
     * バインダーを削除します。
     *
     * @param BinderDeleteRequest $request
     * @return IlluminateHttpResponse
     */
    public function execute(BinderDeleteRequest $request);
}