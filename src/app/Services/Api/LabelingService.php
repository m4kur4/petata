<?php

namespace App\Services\Api;

use App\Http\Requests\LabelingRequest;
use App\Services\Api\Interfaces\LabelingServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

use Log;

/**
 * @inheritdoc
 */
class LabelingService implements LabelingServiceInterface
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
    public function execute(LabelingRequest $request)
    {
        if ($this->isExistLabeling($request->label_id, $request->image_id)) {
            
            // ラベリングが既に存在する場合は解除する
            $this->binder_repository->deleteLabeling($request);
            return config('_const.HTTP_STATUS.OK');
            
        } else {
            $this->binder_repository->addLabeling($request);
            return config('_const.HTTP_STATUS.CREATED');
        }
    }

    /**
     * 指定したラベルと画像の組み合わせでラベリングが存在するかを判定します。
     * 
     * @param string $label_id ラベルID
     * @param string $image_id 画像ID
     */
    private function isExistLabeling($label_id, $image_id)
    {
        return $this->binder_repository->isExistLabeling($label_id, $image_id);
    }
}