<?php

namespace App\Helpers;

use Storage;

/**
 * ファイル操作のヘルパクラスです。
 */
class FileManageHelper
{
    /**
     * S3上に格納されているバインダー画像のフルパスを取得します。
     * 
     * @param Image $image
     */
    public static function getBinderImagePath($image)
    {
        $disk = Storage::disk('s3');

        // <ベースディレクトリ> / <バインダーID> / <ファイル物理名>.<ファイル拡張子>
        $format = '%s/%s/%s.%s';
        $full_path = sprintf(
            $format, 
            config('_const.UPLOAD_DIRECTORY.BINDER'), 
            $image->binder_id, 
            $image->path, 
            $image->extension, 
        );

        return $full_path;
    }
}