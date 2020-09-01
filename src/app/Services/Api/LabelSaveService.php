<?php

namespace App\Services\Api;

use App\Http\Requests\LabelSaveRequest;
use App\Services\Api\Interfaces\LabelSaveServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Auth;

/**
 * @inheritdoc
 */
class LabelSaveService implements LabelSaveServiceInterface
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
    public function execute(LabelSaveRequest $request)
    {
        // NOTE: リポジトリのメソッドが配列を引数とするためキャスト
        $label_posts = [$request];

        // ラベルの保存
        $label = $this->binder_repository->saveLabels($request->binder_id, $label_posts);

        return $label;
    }
}