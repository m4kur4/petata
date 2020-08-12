<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\Front\UserRegistrationRequest;
use App\Services\Api\Interfaces\UserRegistrationServiceInterface;
use \App\Repositories\Interfaces\UserRepositoryInterface;

class UserRegistrationService implements UserRegistrationServiceInterface
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
    public function execute(UserRegistrationRequest $request) : User
    {
        $user = $this->userRepository->create($request);
        return $user;
    }
}