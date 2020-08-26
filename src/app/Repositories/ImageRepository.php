<?php

namespace App\Repositories;

use App\Models\Image;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageRemoveRequest;

use DB;
use Log;

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
        dd($request);

        // TODO: 実装
        $image = new Image([
            'upload_user_id' => Auth::id(),
            'name' => $request->images[0]->getClientOriginalName(),
            'visible' => config('_const.IMAGE.VISIBLE.SHOW')
        ]);
        $image->save();
        
        $path = Storage::disk('s3')->putFile('myprefix', $request->images[0], 'public');
        $post->image_url = Storage::disk('s3')->url($path);

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