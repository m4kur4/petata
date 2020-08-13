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
    public function execute(string $user_id): IlluminateHttpResponse
    {
        // TODO: 実装
    }

}