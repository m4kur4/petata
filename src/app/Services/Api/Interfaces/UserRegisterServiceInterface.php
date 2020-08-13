<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use App\Http\Requests\UserRegisterRequest;

/**
 * ユーザー登録サービス
 */
interface UserRegisterServiceInterface
{
    /**
     * ユーザーを新規登録します。
     * 登録したユーザー情報を返却します。
     *
     * @param UserRegisterRequest $request
     * @return User
     */
    public function execute(UserRegisterRequest $request) : User;
}