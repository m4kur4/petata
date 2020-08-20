<?php

namespace App\Repositories;

use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\User;
use App\Models\Label;
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

        // バインダーの作成
        $binder = $this->createBinder($request);

        // バインダー操作権限の付与
        $this->addBinderAuthority(
            $binder->create_user_id,
            $binder->id,
            config('_const.BINDER_AUTHORITY.LEVEL.OWNER')
        );

        // ラベルの追加
        $this->addLabels($binder->id, $request->labels);

        return $binder;
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
    }

    /**
     * @inheritdoc
     */
    public function addLabels(string $binder_id, ?array $label_posts)
    {
        if (empty($label_posts)) {
            return;
        }

        foreach ($label_posts as $post) {
            $label = new Label([
                'binder_id' => $binder_id,
                'name' => $post['name'],
                'description' => $post['description']
            ]);

            $label->save();
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
        // ログインユーザーを作成者とする
        $create_user_id = Auth::id();

        $binder = new Binder([
            'create_user_id' => $create_user_id,
            'name' => $request->binder_name,
            'description' => $request->description
        ]);
        $binder->save();

        return $binder;
    }
}
