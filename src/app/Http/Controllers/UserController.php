<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\UserRegistrationServiceInterface;
use App\Services\Api\Interfaces\UserLoginServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * ユーザー管理コントローラー
 */
class UserController extends Controller
{
    /**
     * コンストラクタ
     * 
     * @param UserRegistrationServiceInterface $userRegistrationService
     * @param UserLoginServiceInterface $userLoginService
     */
    public function __construct(
        UserRegistrationServiceInterface $userRegistrationService,
        UserLoginServiceInterface $userLoginService
    )
    {
        $this->userRegistrationService = $userRegistrationService;
        $this->userLoginService = $userLoginService;
    }

    /**
     * ユーザーを新規登録します。
     * 新規登録したユーザー情報を返却します。
     *
     * @param UserRegistrationRequest $request
     * @return User
     */    
    public function register(UserRegistrationRequest $request) : User
    {
        $user = $this->userRegistrationService->execute($request);
        return $user;
    }

    /**
     * ユーザーを認証してログインさせます。
     */
    public function login(UserLoginRequest $request)
    {
        $this->userLoginService->execute($request);
        return 'hoge';
    }
}
