<?php

namespace App\Services\Api;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Services\Api\Interfaces\ImageSearchServiceInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

use Log;

/**
 * @inheritdoc
 */
class ImageSearchService implements ImageSearchServiceInterface
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
    public function execute(Request $request)
    {
        return $this->image_repository->search($request);
    }
}