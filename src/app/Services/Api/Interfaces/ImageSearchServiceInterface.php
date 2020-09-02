<?php

namespace App\Services\Api\Interfaces;

use Illuminate\Http\Request;

/**
 * 画像検索サービス
 */
interface ImageSearchServiceInterface
{
    /**
     * 指定された条件で絞り込んだ画像のリストを返却します。
     *
     * @param Request $request
     * @return Collection
     */
    public function execute(Request $request);
}