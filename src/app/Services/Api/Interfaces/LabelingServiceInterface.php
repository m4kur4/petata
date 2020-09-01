<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\LabelingRequest;

/**
 * ラベリング存サービス
 */
interface LabelingServiceInterface
{
    /**
     * ラベリングの登録を行います。
     *
     * @param LabelingRequest $request
     * @return string
     */
    public function executeRegister(LabelingRequest $request);
}