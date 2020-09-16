<?php

namespace App\Services\Api;

use App\Http\Requests\MultipleLabelingRequest;
use App\Services\Api\Interfaces\MultipleLabelingServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Log;

/**
 * @inheritdoc
 */
class MultipleLabelingService implements MultipleLabelingServiceInterface
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
    public function execute(MultipleLabelingRequest $request)
    {
        // リクエストに存在するラベルIDのラベリングを全て削除
        $this->binder_repository->deleteLabelingMany($request->label_ids);

        // リクエストに存在する画像IDとラベルIDのすべての組み合わせでラベリングを登録
        $this->binder_repository->addLabelingMany($request->label_ids, $request->image_ids);
    }
}