<?php

namespace App\Repositories;

use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\User;
use App\Models\Label;
use App\Models\Labeling;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Http\Requests\BinderSaveRequest;
use App\Http\Requests\LabelingRequest;

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
    public function create(BinderSaveRequest $request): Binder
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
        $this->saveLabels($binder->id, $request->labels);

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
        // アクセス可能なバインダーのIDリスト
        $accesible_binder_ids = BinderAuthority::query()
            ->select('binder_id')
            ->where('user_id', $user_id)
            ->get();
        
        // バインダーを取得
        $accesible_binders = Binder::with([
                'labels',
                'binderAuthorities',
                'binderFavorites',
            ])
            ->whereIn('id', $accesible_binder_ids)
            ->get();
        
        return $accesible_binders;
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
    public function saveLabels(string $binder_id, ?array $label_posts)
    {
        if (empty($label_posts)) {
            return;
        }

        $saved_labels = [];
        foreach ($label_posts as $index => $post) {
            // ラベルが新規作成のものかどうか
            $is_new_label = ($post['id'] === 0);

            if ($is_new_label) {
                // 新規登録
                $label = new Label([
                    'binder_id' => $binder_id,
                    'name' => $post['name'],
                    'description' => $post['description'],
                    'sort' => $index
                ]);
            } else {
                // 更新登録
                $label = Label::where('id', $post['id'])->first();
                $label->name = $post['name'];
                $label->description = $post['description'];
                $label->sort = $index;
            }

            $label->save();

            array_push($saved_labels, $label);
        }
        return $saved_labels;
    }

    /**
     * @inheritDoc
     */
    public function deleteLabel(string $label_id)
    {
        Label::query()
            ->where('id', $label_id)
            ->delete();
    }

    /**
     * @inheritDoc
     */
    public function selectOneById(string $binder_id)
    {
        $user_id = Auth::id();
        if (empty($user_id) || !$this->isAccessible($user_id, $binder_id)) {
            // 未ログイン、またはログインユーザーにアクセス権限がない場合
            return null;
        }

        $binder = Binder::with([
            'labels',
            'binderAuthorities',
            'binderFavorites',
            'images'
        ])
        ->where('id', $binder_id)
        ->first();

        return $binder;
    }

    /**
     * @inheritDoc
     */
    public function isExistLabeling($label_id, $image_id)
    {
        $isExist = Labeling::query()
            ->where('label_id', $label_id)
            ->where('image_id', $image_id)
            ->exists();
        
        return $isExist;
    }

    /**
     * @inheritDoc
     */
    public function addLabeling(LabelingRequest $request)
    {
        $labeling = new Labeling([
            'label_id' => $request->label_id,
            'image_id' => $request->image_id,
        ]);

        $labeling->save();
    }

    /**
     * @inheritdoc
     */
    public function deleteLabeling(LabelingRequest $request)
    {
        Labeling::query()
            ->where('label_id', $request->label_id)
            ->where('image_id', $request->image_id)
            ->delete();
    }

    /**
     * @inheritdoc
     */
    public function selectLabelsRelatedToBinder(string $binder_id)
    {
        $labels = Label::query()
            ->where('binder_id', $binder_id)
            ->get();
        return $labels;
    }

    /**
     * 指定したユーザーが指定したバインダーへアクセス可能かを判定します。
     * 
     * @param string $user_id ユーザーID
     * @param string $binder_id バインダーID
     * @return bool
     */
    private function isAccessible($user_id, $binder_id)
    {
        $result = BinderAuthority::query()
            ->where('user_id', $user_id)
            ->where('binder_id', $binder_id)
            ->exists();
        
        return $result;
    }

    /**
     * バインダーテーブルへ新規レコードを作成します。
     *
     * @param BinderSaveRequest $request
     * @return Binder 
     */
    private function createBinder(BinderSaveRequest $request): Binder
    {
        // ログインユーザーを作成者とする
        $create_user_id = Auth::id();

        $binder = new Binder([
            'create_user_id' => $create_user_id,
            'name' => $request->name,
            'description' => $request->description
        ]);
        $binder->save();

        return $binder;
    }


}
