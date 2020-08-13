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
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
      UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritdoc
     */
    public function execute(UserRegisterRequest $request) : User
    {
        $user = $this->userRepository->create($request);
        return $user;
    }
}