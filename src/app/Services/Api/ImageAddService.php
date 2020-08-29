<?php

namespace App\Services\Api;

use App\Models\Image;
use App\Http\Requests\ImageAddRequest;
use App\Services\Api\Interfaces\ImageAddServiceInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

use Log;

/**
 * @inheritdoc
 */
class ImageAddService implements ImageAddServiceInterface
{
    /**
     * コンストラクタ
     * 
     * @param BinderRepositoryInterface $binder_repository
     */
    public function __construct(
        ImageRepositoryInterface $image_repository
      )
      {
          $this->image_repository = $image_repository;
      }

    /**
     * @inheritDoc
     */
    public function execute(ImageAddRequest $request)
    {
        $filepath = $this->image_repository->add($request);
        $response = ['path' => $filepath];
        return response($response, config('_const.HTTP_STATUS.CREATED'));
    }
}