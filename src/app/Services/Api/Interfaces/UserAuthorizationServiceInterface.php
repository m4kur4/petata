<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use App\Http\Requests\Front\UserRegistrationRequest;

/**
 * ユーザー認証サービス
 */
interface UserAuthorizationServiceInterface
{
    public function login();
}
