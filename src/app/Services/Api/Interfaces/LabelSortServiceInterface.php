<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\LabelSortRequest;

/**
 * ラベル並び順更新サービス
 */
interface LabelSortServiceInterface
{
    /**
     * ラベルの並び順を更新します。
     * 更新後のラベルのリストを返却します。
     *
     * @param LabelSortRequest $request
     * @return Collection(Label)
     */
    public function execute(LabelSortRequest $request);
}