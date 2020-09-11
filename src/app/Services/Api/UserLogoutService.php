<?php

namespace App\Services\Api;

use App\Models\User;
use App\Services\Api\Interfaces\UserLogoutServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * @inheritdoc
 */
class UserLogoutService implements UserLogoutServiceInterface
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
    public function execute(Request $request)
    {
        $this->logout($request);
    }

    /**
     * @see AuthenticatesUsers#loggedOut
     */
    protected function loggedOut($request)
    {
        $request->session()->regenerate();
        return $request;
    }
}