<?php

namespace App\Repositories\Interfaces;

use App\Models\Binder;
use App\Http\Requests\BinderCreateRequest;

interface BinderRepositoryInterface
{
    /**
     * バインダーを新規作成します。
     *
     * @param @param UserRegisterRequest $request
     * @return User
     */
    public function create(BinderCreateRequest $request);

    /**
     * 指定したIDを持つバインダーを削除します。
     * 対象のバインダーに関連する各種データも同時に削除します。
     *
     * @param string $binder_id
     * @return void
     */
    public function delete(string $binder_id);

    /**
     * 指定したユーザーIDに参照権限が付与されているバインダーを取得します。
     *
     * @param string $user_id
     * @return Collection
     */
    public function selectByAuthorizedUserId(string $user_id);
}