<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\UserRegistrationRequest;
use App\Services\Api\Interfaces\UserRegistrationServiceInterface;
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
     */
    public function __construct(
        UserRegistrationServiceInterface $userRegistrationService
        )
    {
        $this->userRegistrationService = $userRegistrationService;
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
}
