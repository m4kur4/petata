<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Http\Requests\Front\UserRegistrationRequest;

interface UserRepositoryInterface
{
    /**
     * ユーザーを新規登録します。
     * 登録したユーザー情報を返却します。
     *
     * @param @param UserRegistrationRequest $request
     * @return User
     */
    public function create(UserRegistrationRequest $request): User;
}