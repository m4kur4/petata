<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\LabelDeleteRequest;

/**
 * ラベル削除サービス
 */
interface LabelDeleteServiceInterface
{
    /**
     * ラベルを削除します。
     * 削除後のラベルのリストを返却します。
     *
     * @param LabelDeleteRequest $request
     * @return Collection(Label)
     */
    public function execute(LabelDeleteRequest $request);
}