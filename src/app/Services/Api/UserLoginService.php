<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\UserLoginServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Log;

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
        // 継続ログインの設定
        if (!empty($request->remember)) {
            Auth::attempt(['email' => $request->email, 'password' => $request->password], true);
        } else {
            $user->setRememberToken(null);
            $user->save();
        }

        return $user;
    }

    /**
     * @see AuthenticatesUsers#authenticated
     */
    protected function authenticated($request, $user)
    {
        return $user;
    }
}