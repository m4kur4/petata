<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use App\Http\Requests\Front\UserRegistrationRequest;

/**
 * ユーザー登録サービス
 */
interface UserRegistrationServiceInterface
{
    /**
     * ユーザーを新規登録します。
     * 登録したユーザー情報を返却します。
     *
     * @param UserRegistrationRequest $request
     * @return User
     */
    public function register(UserRegistrationRequest $request) : User;
}