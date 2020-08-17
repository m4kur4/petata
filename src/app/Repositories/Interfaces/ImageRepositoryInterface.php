<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageRemoveRequest;

interface ImageRepositoryInterface
{
    /**
     * 画像１枚を新規追加します。
     *
     * @return Image
     */
    public function add(ImageAddRequest $request);

    /**
     * 画像を複数枚新規追加します。
     *
     * @return Collection(Image)
     */
    public function addMany(ImageAddRequest $request);

    /**
     * 画像１枚を削除します。
     */
    public function remove(ImageRemoveRequest $request);

    /**
     * 画像を複数枚削除します。
     */
    public function removeMany(ImageRemoveRequest $request);
}