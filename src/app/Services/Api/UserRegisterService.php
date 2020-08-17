<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\UserRegisterRequest;
use App\Services\Api\Interfaces\UserRegisterServiceInterface;
use \App\Repositories\Interfaces\UserRepositoryInterface;

/**
 * @inheritdoc
 */
class UserRegisterService implements UserRegisterServiceInterface
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
    public function execute(UserRegisterRequest $request) : User
    {
        $user = $this->user_repository->create($request);
        return $user;
    }
}