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
    /**
     * @inheritdoc
     */
    public function add(ImageAddRequest $request)
    {
        // TODO: バインダーを開いていない状態でアップロードさせない
        // $binder_id = Session::get('binder-id');
        // if (empty($binder_id)) {
        // }

        $image = new Image([
            'binder_id' => $request->binder_id,
            'upload_user_id' => Auth::id(),
            'name' => $request->image->getClientOriginalName(),
            'visible' => config('_const.IMAGE.VISIBLE.SHOW'),
            'extension' => $request->image->getClientOriginalExtension(),
        ]);
        $image->save();

        // アップロード先："binder/<バインダーID>"
        $upload_directory = config('_const.UPLOAD_DIRECTORY.BINDER') . '/' . $request->binder_id;
        
        // アップロード
        $path = Storage::disk('s3')->putFileAs(
            $upload_directory, 
            $request->image, 
            ($image->path . '.' . $image->extension),
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