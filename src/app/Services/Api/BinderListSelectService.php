<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * @inheritdoc
 */
class BinderListSelectService implements BinderListSelectServiceInterface
{
    /**
     * コンストラクタ
     * 
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(
      UserRepositoryInterface $user_repository
    )
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @inheritdoc
     */
    public function execute(string $user_id)
    {
        // TODO: 実装
    }

}