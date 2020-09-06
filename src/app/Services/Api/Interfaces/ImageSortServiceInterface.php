<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\ImageSortRequest;

/**
 * 画像並び順更新サービス
 */
interface ImageSortServiceInterface
{
    /**
     * バインダー画像の並び順を更新します。
     * 更新後のバインダー画像のリストを返却します。
     *
     * @param ImageSortRequest $request
     * @return Collection(Image)
     */
    public function execute(ImageSortRequest $request);
}