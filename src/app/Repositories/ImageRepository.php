<?php

namespace App\Repositories;

use App\Models\Image;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageRemoveRequest;

use Log;

class ImageRepository implements ImageRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function add(ImageAddRequest $request)
    {
        // TODO: 実装
    }

    /**
     * @inheritdoc
     */
    public function addMany(ImageRemoveRequest $request)
    {
        // TODO: 実装
    }

    /**
     * @inheritdoc
     */
    public function remove(ImageAddRequest $request)
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