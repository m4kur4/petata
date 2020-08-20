<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\UserRegisterServiceInterface;
use App\Services\Api\Interfaces\UserLoginServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * ユーザーコントローラー
 */
class UserController extends Controller
{
    /**
     * コンストラクタ
     * 
     * @param UserRegisterServiceInterface $user_register_service
     * @param UserLoginServiceInterface $user_login_service
     */
    public function __construct(
        UserRegisterServiceInterface $user_register_service,
        UserLoginServiceInterface $user_login_service
    )
    {
        $this->user_register_service = $user_register_service;
        $this->user_login_service = $user_login_service;
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
        $user = $this->user_register_service->execute($request);
        return $user;
    }

    /**
     * ユーザーを認証してログインさせます。
     */
    public function login(UserLoginRequest $request)
    {
        $this->user_login_service->execute($request);
        return 'hoge';
    }
}
