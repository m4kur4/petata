<?php

namespace App\Services\Api;

use App\Http\Requests\ImageDeleteRequest;
use App\Services\Api\Interfaces\ImageDeleteServiceInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

use Auth;
use Log;

/**
 * @inheritdoc
 */
class ImageDeleteService implements ImageDeleteServiceInterface
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
    public function execute(ImageDeleteRequest $request)
    {
        // 画像の削除
        $this->image_repository->delete($request);

        // 削除後の画像のリストを取得
        $images = $this->image_repository->search($request);

        return $images;
    }
}