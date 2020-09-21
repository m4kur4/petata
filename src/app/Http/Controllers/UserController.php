<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Services\Api\Interfaces\PasswordResetServiceInterface;
use App\Services\Api\Interfaces\UserRegisterServiceInterface;
use App\Services\Api\Interfaces\UserLoginServiceInterface;
use App\Services\Api\Interfaces\UserLogoutServiceInterface;

use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

use Auth;
use Log;

/**
 * ユーザーコントローラー
 */
class UserController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * コンストラクタ
     * 
     * @param PasswordResetServiceInterface $password_reset_service
     * @param UserRegisterServiceInterface $user_register_service
     * @param UserLoginServiceInterface $user_login_service
     * @param UserLogoutService $user_logout_service
     */
    public function __construct(
        PasswordResetServiceInterface $password_reset_service,
        UserRegisterServiceInterface $user_register_service,
        UserLoginServiceInterface $user_login_service,
        UserLogoutServiceInterface $user_logout_service
    )
    {
        $this->password_reset_service = $password_reset_service;
        $this->user_register_service = $user_register_service;
        $this->user_login_service = $user_login_service;
        $this->user_logout_service = $user_logout_service;

        $this->middleware('guest')->except(['getLoginUser', 'logout', 'remind', 'resetPassword']);
    }

    /**
     * ログインユーザー情報を取得します。
     * ログインセッションが存在しない場合は空文字を返却します。
     */
    public function getLoginUser()
    {
        if(Auth::id() == null) {
            return '';
        }
        return User::find(Auth::id());
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
        $user = $this->user_login_service->execute($request);
        return $user;
    }

    /**
     * ユーザーをログアウトさせます。
     */
    public function logout(Request $request)
    {
        $user = $this->user_logout_service->execute($request);
    }

    /**
     * パスワードリマインダーメールを送信します。
     */
    public function remind(Request $request)
    {
        Log::debug($request);
        return $this->sendResetLinkEmail($request);
        //return response([], config('_const.HTTP_STATUS.OK'));
    }

    /**
     * パスワードリセットを実行します。
     */
    public function resetPassword(PasswordResetRequest $request)
    {
        $user = $this->password_reset_service->execute($request);
        return $user;
    }
}
