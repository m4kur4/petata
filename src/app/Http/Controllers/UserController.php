<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\UserRegisterServiceInterface;
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
     * @param UserRegisterServiceInterface $UserRegisterService
     * @param UserLoginServiceInterface $userLoginService
     */
    public function __construct(
        UserRegisterServiceInterface $UserRegisterService,
        UserLoginServiceInterface $userLoginService
    )
    {
        $this->UserRegisterService = $UserRegisterService;
        $this->userLoginService = $userLoginService;
    }

    /**
     * ユーザーを新規登録します。
     * 新規登録したユーザー情報を返却します。
     *
     * @param UserRegisterRequest $request
     * @return User
     */    
    public function register(UserRegisterRequest $request) : User
    {
        $user = $this->UserRegisterService->execute($request);
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
