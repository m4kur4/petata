<?php

namespace App\Repositories;

use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\User;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Http\Requests\BinderCreateRequest;

use Auth;
use DB;
use Log;

/**
 * @inheritdoc
 */
class BinderRepository implements BinderRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function create(BinderCreateRequest $request): Binder
    {
        DB::beginTransaction();
        try {
            // バインダーの作成
            $binder = $this->createBinder($request);
            
            // バインダー操作権限の付与
            $this->addBinderAuthority(
                $binder->create_user_id,
                $binder->id,
                config('_const.BINDER_AUTHORITY.LEVEL.OWNER')
            );

            DB::commit();
            return $binder;

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @inheritdoc
     */
    public function delete(string $binder_id)
    {
        // TODO: 実装
        DB::beginTransaction();
        try {
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * @inheritdoc
     */
    public function selectByAuthorizedUserId(string $user_id)
    {
        $user = User::find($user_id);
        return $user->accessibleBinders();
    }

    /**
     * @inheritdoc
     */
    public function addBinderAuthority($user_id, $binder_id, $level)
    {
        // TODO: 実装
        DB::beginTransaction();
        try {
            // 想定しない値が設定された場合はエラー
            if (!in_array($level, config('_const.BINDER_AUTHORITY.LEVEL'))) {
                throw $e;
            }

            $binder_authority = new BinderAuthority([
                'user_id' => $user_id,
                'binder_id' => $binder_id,
                'level' => $level
            ]);
        
            $binder_authority->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * バインダーテーブルへ新規レコードを作成します。
     *
     * @param BinderCreateRequest $request
     * @return Binder 
     */
    private function createBinder(BinderCreateRequest $request): Binder
    {
        // TODO: 実装
        DB::beginTransaction();
        try {
            // ログインユーザーを作成者とする
            $create_user_id = Auth::id();

            $binder = new Binder([
                'create_user_id' => $create_user_id,
                'name' => $request->binder_name
            ]);
            $binder->save();
            
            DB::commit();
            return $binder;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

    }
}