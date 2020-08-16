<?php

namespace App\Repositories;

use App\Models\Binder;
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
        // TODO: 実装
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
}