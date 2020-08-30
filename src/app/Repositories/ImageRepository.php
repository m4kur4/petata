<?php

namespace App\Repositories;

use App\Models\Image;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageRemoveRequest;

use Auth;
use DB;
use Log;
use Storage;

/**
 * @inheritdoc
 */
class ImageRepository implements ImageRepositoryInterface
{
    // アップロード先
    const UPLOAD_DIRECTORY_BINDER = 'binder';
    const UPLOAD_DIRECTORY_USER = 'user';

    /**
     * @inheritdoc
     */
    public function add(ImageAddRequest $request)
    {
        // TODO: バインダーを開いていない状態でアップロードさせない
        // $binder_id = Session::get('binder-id');
        // if (empty($binder_id)) {
        // }

        // TODO: ファイル名の設定
        $image = new Image([
            'binder_id' => $request->binder_id,
            'upload_user_id' => Auth::id(),
            'name' => $request->image->getClientOriginalName(),
            'visible' => config('_const.IMAGE.VISIBLE.SHOW')
        ]);
        $image->save();

        // アップロード先："binder/<バインダーID>"
        $upload_directory = self::UPLOAD_DIRECTORY_BINDER . '/' . $request->binder_id;
        
        // アップロード
        // TODO: S3へアップロードする
        //$path = Storage::disk('s3')->putFileAs(
        $path = Storage::disk('local')->putFileAs(
            $upload_directory, 
            $request->image, 
            $image->path,
            'public'
        );

        return $path;
    }

    /**
     * @inheritdoc
     */
    public function addMany(ImageAddRequest $request)
    {
        // TODO: 実装
    }

    /**
     * @inheritdoc
     */
    public function remove(ImageRemoveRequest $request)
    {
        // TODO: 実装
    }

    /**
     * @inheritdoc
     */
    public function removeMany(ImageRemoveRequest $request)
    {
        // TODO: 実装
    }
}