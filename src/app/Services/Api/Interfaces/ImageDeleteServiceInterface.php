<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\ImageDeleteRequest;

/**
 * 画像削除サービス
 */
interface ImageDeleteServiceInterface
{
    /**
     * バインダー画像を削除します。
     * 削除後のバインダー画像のリストを返却します。
     *
     * @param ImageDeleteRequest $request
     * @return Collection(Image)
     */
    public function execute(ImageDeleteRequest $request);
}