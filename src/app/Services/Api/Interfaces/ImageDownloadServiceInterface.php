<?php

namespace App\Services\Api\Interfaces;

use Illuminate\Http\Request;

/**
 * 画像ダウンロードサービス
 */
interface ImageDownloadServiceInterface
{
    /**
     * 複数のバインダー画像をzip形式でダウンロードします。
     *
     * @param Request $request
     */
    public function execute(Request $request);
}