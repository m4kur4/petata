<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use App\Http\Requests\BinderSaveRequest;

/**
 * バインダー作成サービス
 */
interface BinderSaveServiceInterface
{
    /**
     * バインダーを新規作成します。
     *
     * @param BinderSaveRequest $request
     */
    public function execute(BinderSaveRequest $request);
}