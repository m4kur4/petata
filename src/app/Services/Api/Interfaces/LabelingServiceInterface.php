<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\LabelingRequest;

/**
 * ラベリング存サービス
 */
interface LabelingServiceInterface
{
    /**
     * ラベリングの登録・登録解除を行います。
     * 登録に成功した場合、ステータスコード201を返却します。
     * 登録解除に成功した場合、ステータスコード200を返却します。
     *
     * @param LabelingRequest $request
     * @return int
     */
    public function execute(LabelingRequest $request);
}