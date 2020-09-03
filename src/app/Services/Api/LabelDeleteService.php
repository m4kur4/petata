<?php

namespace App\Services\Api;

use App\Http\Requests\LabelDeleteRequest;
use App\Services\Api\Interfaces\LabelDeleteServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Auth;

/**
 * @inheritdoc
 */
class LabelDeleteService implements LabelDeleteServiceInterface
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
    public function execute(LabelDeleteRequest $request)
    {
        // ラベルの削除
        $label = $this->binder_repository->deleteLabel($request->label_id);

        // 削除後のラベルのリストを取得
        $labels = $this->binder_repository->selectLabelsRelatedToBinder($request->binder_id);

        return $labels;
    }
}