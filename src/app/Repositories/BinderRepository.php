<?php

namespace App\Repositories;

use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\User;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Http\Requests\BinderCreateRequest;

class BinderRepository implements BinderRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(BinderCreateRequest $request)
    {
        $binder_id = $this->createBinder($request);

        $binder_authority = new BinderAuthority;
    }

    /**
     * @inheritdoc
     */
    public function delete(string $binder_id)
    {
        // TODO: 実装
    }

    /**
     * @inheritdoc
     */
    public function selectByAuthorizedUserId(string $user_id)
    {
        $user = User::find($user_id);
        return $user->accessibleBinders();
    }

    /**
     * バインダーテーブルへ新規レコードを作成します。
     *
     * @param BinderCreateRequest $request
     * @return $id バインダーID
     */
    private function createBinder(BinderCreateRequest $request)
    {
        $binder = new Binder([
            'create_user_id' => Auth::id(),
            'name' => $request->binder_name
        ]);
        $binder->save();
        
        return $binder->id;
    }

    /**
     * ユーザーへバインダーの操作権限を付与します。
     */
    public function addBinderAuthority($user_id)
    {}
}