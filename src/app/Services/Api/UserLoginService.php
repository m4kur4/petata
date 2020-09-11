<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\UserLoginServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 * @inheritdoc
 */
class UserLoginService implements UserLoginServiceInterface
{
    use AuthenticatesUsers;

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
    public function execute(UserLoginRequest $request)
    {
        return $this->login($request);
    }

    /**
     * @see AuthenticatesUsers#authenticated
     */
    protected function authenticated($request, $user)
    {
        return $user;
    }
}