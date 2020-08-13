<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\UserLoginRequest;
use App\Models\User;

/**
 * ユーザーログインサービス
 */
interface UserLoginServiceInterface
{
    /**
     * ユーザーを認証してログインさせます。
     *
     * @param UserLoginRequest $request
     * @return void
     */
    public function execute(UserLoginRequest $request);
}