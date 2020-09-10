<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\BinderSaveRequest;
use App\Services\Api\Interfaces\BinderSaveServiceInterface;
use \App\Repositories\Interfaces\BinderRepositoryInterface;

use Auth;
use Log;

/**
 * @inheritdoc
 */
class BinderSaveService implements BinderSaveServiceInterface
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
    public function execute(BinderSaveRequest $request)
    {
        // リクエストがバインダー新規作成かどうか
        $NEW_RECORD_ID = 0;
        $is_new_record = ($request->id == $NEW_RECORD_ID);

        if ($is_new_record) {
            // 新規作成の場合
            $this->binder_repository->create($request);
        } else {
            // 更新登録の場合
            $this->binder_repository->update($request);
        }

        // ログインユーザーがアクセス可能なバインダーのリストを返却
        $user_id = Auth::id();
        $binder_list = $this->binder_repository->selectByAuthorizedUserId($user_id);
        return $binder_list;
    }
}