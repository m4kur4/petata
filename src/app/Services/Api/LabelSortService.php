<?php

namespace App\Services\Api;

use App\Http\Requests\LabelSortRequest;
use App\Services\Api\Interfaces\LabelSortServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Auth;
use Log;

/**
 * @inheritdoc
 */
class LabelSortService implements LabelSortServiceInterface
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
    public function execute(LabelSortRequest $request)
    {
        // ラベルの並び順を更新
        $this->binder_repository->updateLabelSort($request);

        // 更新後のラベルのリストを取得
        $labels = $this->binder_repository->selectLabelsRelatedToBinder($request->binder_id);

        return $labels;
    }
}