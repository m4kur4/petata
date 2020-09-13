<?php

namespace App\Helpers;

use Log;
use Storage;

/**
 * ファイル操作のヘルパクラスです。
 */
class FileManageHelper
{
    /**
     * S3上に格納されているバインダー画像の絶対パスを取得します。
     * 
     * @param Image $image
     * @param string [option]$extension 拡張子
     */
    public static function getBinderImageRelativePath($image, $extension = null)
    {
        // オリジナル画像かどうか
        $is_original = ($extension == null);

        $disk = Storage::disk('s3');
        // DEBUG: public
        //$disk = Storage::disk('public');

        // <ベースディレクトリ> / <中間パス(バインダーID | バインダーID/org)> / <ファイル物理名>.<ファイル拡張子>
        $format = '%s/%s/%s.%s';

        // 拡張子が指定されていない場合はオリジナル画像のディレクトリを参照する
        $middle_path = $is_original ? ($image->binder_id . '/org') : $image->binder_id;

        // ルートディレクトリからの相対パス
        $relative_path = sprintf(
            $format, 
            config('_const.UPLOAD_DIRECTORY.BINDER'), 
            $middle_path, 
            $image->path, 
            $is_original ? $image->extension: $extension, 
        );

        return $relative_path;
    }

    /**
     * S3上に格納されているバインダー画像の絶対パスを取得します。
     * 
     * @param Image $image
     * @param string [option]$extension 拡張子
     */
    public static function getBinderImagePath($image, $extension = null)
    {
        $disk = Storage::disk('s3');

        // 相対パスを取得
        $relative_path = self::getBinderImageRelativePath($image, $extension);

        // 絶対パスを返却
        $absolute_path = $disk->url($relative_path);

        // DEBUG: public
        //$absolute_path = asset('storage/' . $relative_path);

        return $absolute_path;
    }

    /**
     * S3上に格納されている指定されたバインダー画像の格納ディレクトリについて、
     * 相対パスを取得します。
     * NOTE: png画像
     * 
     * @param int $binder_id バインダーID
     */
    public static function getBinderImageDirectoryPath($binder_id)
    {
        return config('_const.UPLOAD_DIRECTORY.BINDER') . '/' . $binder_id;
    }

}