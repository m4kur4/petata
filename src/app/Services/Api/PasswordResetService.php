<?php

namespace App\Services\Api;

use App\Models\User;
use App\Http\Requests\PasswordResetRequest;
use App\Services\Api\Interfaces\PasswordResetServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Log;

/**
 * @inheritdoc
 */
class PasswordResetService implements PasswordResetServiceInterface
{
    use ResetsPasswords;

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
    public function execute(PasswordResetRequest $request)
    {
        $this->reset($request);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        return $user;
    }

}