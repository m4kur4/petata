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
     * アップロード先のファイルパスを返却します。
     *
     * @param LabelSaveRequest $request
     * @return string
     */
    public function execute(LabelSaveRequest $request);
}