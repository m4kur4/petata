<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Http\Requests\UserRegisterRequest;

use Hash;
use Log;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(UserRegisterRequest $request): User
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    /**
     * @inheritdoc
     */
    public function delete(string $user_id)
    {
        $user = User::where('id', $user_id);
        $user->delete();

        // TODO: 関連データも削除する
    }
}