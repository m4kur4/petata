<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageDeleteRequest;
use App\Http\Requests\ImageRenameRequest;
use App\Http\Requests\ImageSortRequest;

/**
 * 画像リポジトリ
 */
interface ImageRepositoryInterface
{
    public function search(Request $request);

    /**
     * 画像１枚を新規追加します。
     * アップロード先のファイルパスを返却します。
     *
     * @return string
     */
    public function add(ImageAddRequest $request);

    /**
     * 画像１枚を削除します。
     */
    public function delete(ImageDeleteRequest $request);

    /**
     * 指定したバインダーに紐づくすべての画像を削除します。
     */
    public function deleteAll(int $binder_id);

    /**
     * 画像をリネームします。
     */
    public function rename(ImageRenameRequest $request);

    /**
     * 画像の並び順を更新します。
     * 
     * 指定した画像の並び順を指定した値とし、
     * 当該画像の並び順が移動しただけ他の画像の並び順を詰めるように更新を行います。
     * 
     * @param ImageSortRequest $request
     */
    public function updateSort(ImageSortRequest $request);
}