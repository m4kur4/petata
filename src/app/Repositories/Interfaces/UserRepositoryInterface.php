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

    /**
     * 指定したIDを持つユーザーを削除します。
     * 対象のユーザーに関連する各種データも同時に削除します。
     *
     * @param string $id
     * @return void
     */
    public function delete(string $id);
}