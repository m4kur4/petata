<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use App\Http\Requests\BinderCreateRequest;

/**
 * バインダー作成サービス
 */
interface BinderCreateServiceInterface
{
    /**
     * バインダーを新規作成します。
     *
     * @param BinderCreateRequest $request
     */
    public function execute(BinderCreateRequest $request);
}