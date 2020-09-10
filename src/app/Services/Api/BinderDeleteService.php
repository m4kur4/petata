<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\BinderDeleteRequest;
use App\Services\Api\Interfaces\BinderDeleteServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Repositories\Interfaces\ImageRepositoryInterface;

/**
* @inheritdoc
*/
class BinderDeleteService implements BinderDeleteServiceInterface
{
    /**
     * コンストラクタ
     * 
     * @param BinderRepositoryInterface $binder_repository
     * @param ImageRepositoryInterface $image_repository
     */
    public function __construct(
        BinderRepositoryInterface $binder_repository,
        ImageRepositoryInterface $image_repository
    )
    {
        $this->binder_repository = $binder_repository;
        $this->image_repository = $image_repository;
    }
  
    /**
     * @inheritdoc
     */
    public function execute(BinderDeleteRequest $request)
    {
        $this->binder_repository->delete($request->binder_id);
        $this->image_repository->deleteAll($request->binder_id);
    }
}