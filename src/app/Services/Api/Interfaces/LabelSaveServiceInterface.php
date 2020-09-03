<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\LabelSaveRequest;

/**
 * ラベル保存サービス
 */
interface LabelSaveServiceInterface
{
    /**
     * ラベルをバインダーへ設定します。
     * 設定後のラベルのリストを返却します。
     *
     * @param LabelSaveRequest $request
     * @return Collection(Label)
     */
    public function execute(LabelSaveRequest $request);
}