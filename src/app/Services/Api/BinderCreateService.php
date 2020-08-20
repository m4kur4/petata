<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\BinderCreateRequest;
use App\Services\Api\Interfaces\BinderCreateServiceInterface;
use \App\Repositories\Interfaces\BinderRepositoryInterface;

use Auth;

/**
 * @inheritdoc
 */
class BinderCreateService implements BinderCreateServiceInterface
{
    /**
     * コンストラクタ
     * 
     * @param BinderRepositoryInterface $binder_repository
     */
    public function __construct(
        BinderRepositoryInterface $binder_repository
    )
    {
        $this->binder_repository = $binder_repository;
    }

    /**
     * @inheritdoc
     */
    public function execute(BinderCreateRequest $request)
    {
        // バインダーの新規作成
        $this->binder_repository->create($request);

        // ログインユーザーがアクセス可能なバインダーのリストを返却
        $user_id = Auth::id();
        $binder_list = $this->binder_repository->selectByAuthorizedUserId($user_id);
        return $binder_list;
    }
}