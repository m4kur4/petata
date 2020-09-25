<?php

namespace App\Traits;

use App\Models\Binder;

use Log;

/**
 * バインダー関連の処理をサポートするトレイトです。
 */
trait BinderTrait
{

    /**
     * バインダーリストに表示されるサムネイル画像のURLを取得します。
     * サムネイルには「並び順が最も若い画像」を使用します。
     * 
     * @param Binder $binder
     */
    private function getBinderThumbnailUrl(Binder $binder)
    {
        $first_image = $binder
            ->images
            ->sortBy('sort')
            ->values()
            ->first();

        if (empty($first_image)) {
            // 画像がない場合はダミーを表示
            return '/image/dummy/dummy.jpg';
        } else {
            return $first_image->storage_file_path;
        }
    }
}