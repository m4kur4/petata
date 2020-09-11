<?php

namespace App\Services\Api\Interfaces;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * ユーザーログアウトサービス
 */
interface UserLogoutServiceInterface
{
    /**
     * ユーザーをログアウトさせます。
     *
     * @param Request $request
     * @return void
     */
    public function execute(Request $request);
}