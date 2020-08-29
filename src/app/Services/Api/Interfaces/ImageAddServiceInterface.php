<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\ImageAddRequest;

/**
 * 画像追加サービス
 */
interface ImageAddServiceInterface
{
    /**
     * 画像をアップロードしてバインダーへ追加します。
     * アップロード先のファイルパスを返却します。
     *
     * @param ImageAddRequest $request
     * @return string
     */
    public function execute(ImageAddRequest $request);
}