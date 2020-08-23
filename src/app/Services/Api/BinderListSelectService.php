<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;
use App\Repositories\Interfaces\BinderRepositoryInterface;

/**
 * @inheritdoc
 */
class BinderListSelectService implements BinderListSelectServiceInterface
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
    public function execute(string $user_id)
    {
        $binders = $this->binder_repository->selectByAuthorizedUserId($user_id);
        return $binders;
    }

}