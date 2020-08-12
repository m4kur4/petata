<?php

namespace App\Services\Api;

use App\Models\User;
use App\Services\Api\Interfaces\UserAuthorizationServiceInterface;
use \App\Repositories\Interfaces\UserRepositoryInterface;

class UserAuthorizationService implements UserAuthorizationServiceInterface

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
    public function login()
    {
      return null;
    }
}