<?php

namespace App\Services\Api\Interfaces;

use App\Http\Requests\ImageRenameRequest;

/**
 * 画像リネームサービス
 */
interface ImageRenameServiceInterface
{
    /**
     * 画像をリネームします。
     *
     * @param ImageRenameRequest $request
     * @return void
     */
    public function execute(ImageRenameRequest $request);
}