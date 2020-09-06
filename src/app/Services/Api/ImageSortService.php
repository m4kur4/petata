<?php

namespace App\Services\Api;

use App\Http\Requests\ImageSortRequest;
use App\Services\Api\Interfaces\ImageSortServiceInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

use Auth;
use Log;

/**
 * @inheritdoc
 */
class ImageSortService implements ImageSortServiceInterface
{
    /**
     * コンストラクタ
     * 
     * @param ImageRepositoryInterface $image_repository
     */
    public function __construct(
        ImageRepositoryInterface $image_repository
    )
    {
        $this->image_repository = $image_repository;
    }

    /**
     * @inheritdoc
     */
    public function execute(ImageSortRequest $request)
    {
        Log::debug('D2');
        Log::debug($request);
        Log::debug('/ D2');

        $this->image_repository->updateSort($request);
    }
}