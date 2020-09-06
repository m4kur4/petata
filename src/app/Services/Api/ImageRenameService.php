<?php

namespace App\Services\Api;

use App\Models\Image;
use App\Http\Requests\ImageRenameRequest;
use App\Services\Api\Interfaces\ImageRenameServiceInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

use Log;

/**
 * @inheritdoc
 */
class ImageRenameService implements ImageRenameServiceInterface
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
    public function execute(ImageRenameRequest $request)
    {
        $this->image_repository->rename($request);
    }
}