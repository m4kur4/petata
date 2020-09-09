<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\BinderFavoriteRequest;
use App\Services\Api\Interfaces\BinderFavoriteServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

/**
* @inheritdoc
*/
class BinderFavoriteService implements BinderFavoriteServiceInterface
{
    /**
     * コンストラクタ
     * 
     * @param BinderRepositoryInterface $binder_repository
     */
    public function __construct(
        BinderRepositoryInterface $binder_repository
    )
    {
        $this->binder_repository = $binder_repository;
    }
  
    /**
     * @inheritdoc
     */
    public function execute(BinderFavoriteRequest $request)
    {
        $this->binder_repository->updateBinderFavorite($request);
    }
}