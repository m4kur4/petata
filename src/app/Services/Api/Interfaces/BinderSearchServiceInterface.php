<?php

namespace App\Services\Api\Interfaces;

use Illuminate\Http\Request;

/**
 * バインダー検索サービス
 */
interface BinderSearchServiceInterface
{
    /**
     * 指定したユーザーIDにアクセス権限が付与されているバインダーの一覧情報を取得します。
     *
     * @param string $user_id
     * @return IlluminateHttpResponse
     */
    public function execute(Request $request);
}