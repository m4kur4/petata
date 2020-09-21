<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use App\Http\Requests\PasswordResetRequest;

/**
 * パスワードリセットサービス
 */
interface PasswordResetServiceInterface
{
    /**
     * パスワードのリセットを行います。
     * トークンが有効な場合は新たなパスワードを設定します。
     *
     * @param PasswordResetRequest $request
     * @return void
     */
    public function execute(PasswordResetRequest $request);
}