<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\MultipleLabelingRequest;

/**
 * 一括ラベリングサービス
 */
interface MultipleLabelingServiceInterface
{
    /**
     * ラベリングの一括登録・登録解除を行います。
     * リクエストに存在するラベルの全ラベリングを洗い替えします。
     *
     * @param MultipleLabelingRequest $request
     */
    public function execute(MultipleLabelingRequest $request);
}