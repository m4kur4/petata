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
     * 登録に成功した場合はtrueを返却します。
     * 既にリクエストされたラベルと画像が紐づけられている場合、falseを返却します。
     *
     * @param LabelingRequest $request
     * @return string
     */
    public function executeRegister(LabelingRequest $request);
}