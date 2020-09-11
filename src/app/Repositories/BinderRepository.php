<?php

namespace App\Repositories;

use App\Models\Binder;
use App\Models\BinderAuthority;
use App\Models\BinderFavorite;
use App\Models\User;
use App\Models\Label;
use App\Models\Labeling;
use App\Repositories\Interfaces\BinderRepositoryInterface;
use App\Traits\RawSqlBuildTrait;
use App\Http\Requests\BinderSaveRequest;
use App\Http\Requests\BinderFavoriteRequest;
use App\Http\Requests\LabelingRequest;
use App\Http\Requests\LabelDeleteRequest;
use App\Http\Requests\LabelSortRequest;

use Illuminate\Http\Request;

use Auth;
use DB;
use Log;

/**
 * @inheritdoc
 */
class BinderRepository implements BinderRepositoryInterface
{
    /**
     * Sql文生成用のトレイト
     *  - getSortUpdateQueryForward($table_name)
     *  - getSortUpdateQueryBackward($table_name)
     *  - getSortResetQuery($table_name)
     */
    use RawSqlBuildTrait;

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
    public function update(BinderSaveRequest $request)
    {
        // バインダーの保存
        $binder = Binder::find($request->id);

        $binder->name = $request->name;
        $binder->description = $request->description;
        $binder->save();

        // 削除されたラベルの反映
        $label_ids_before = $binder->labels->pluck('id');
        $delete_target_ids = $label_ids_before->diff(collect($request->labels)->pluck('id'));

        // ラベルの更新
        $this->saveLabels($binder->id, $request->labels);

        $this->deleteLabels($delete_target_ids);

        return $binder;
    }

    /**
     * @inheritdoc
     */
    public function delete(string $binder_id)
    {
        Binder::query()
            ->where('id', $binder_id)
            ->delete();
        
        // FIXME: CASCADE DELETEが効かないため暫定対応
        $this->deleteLabelsAll($binder_id);
    }

    /**
     * @inheritdoc
     */
    public function selectByAuthorizedUserId(string $user_id)
    {
        // アクセス可能なバインダーのIDリスト
        $accesible_binder_ids = $this->getAccesibleBinderIds($user_id);
        
        // バインダーを取得
        $accesible_binders = Binder::with([
                'labels',
                'binderAuthorities',
                'binderFavorites',
            ])
            ->whereIn('id', $accesible_binder_ids)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return $accesible_binders;
    }

    /**
     * @inheritdoc
     */
    public function search(Request $request)
    {
        $user_id = Auth::id();
        // アクセス可能なバインダーのIDリスト
        $accesible_binder_ids = $this->getAccesibleBinderIds($user_id);

        //Log::debug('D2');
        //DB::enableQueryLog();
        $search_query = Binder::query()
            ->whereIn('id', $accesible_binder_ids);

        // 検索条件の動的追加
        $this->addSearchWhereOwn($search_query, $request);
        $this->addSearchWhereOthers($search_query, $request);
        $this->addSearchWhereFavorite($search_query, $request);
        $this->addSearchWhereName($search_query, $request);

        //$result = $search_query->get();
        $result = $search_query
            ->orderBy('created_at', 'desc')
            ->get();

        //Log::debug(DB::getQueryLog());
        //Log::debug('/ D2');
        return $result;
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
                // 並び順を後ろへずらす
                $this->shiftSortBackwordAll($binder_id);
                // 新規登録
                $label = new Label([
                    'binder_id' => $binder_id,
                    'name' => $post['name'],
                    'description' => $post['description'],
                    'sort' => 0
                ]);
            } else {
                // 更新登録
                $label = Label::where('id', $post['id'])->first();
                $label->name = $post['name'];
                $label->description = $post['description'];

                if (count($label_posts) > 1) {
                    // バインダー作成(編集)画面からの複数更新時は並び順を更新
                    $label->sort = $index;
                }
            }
            $label->save();

            array_push($saved_labels, $label);
        }

        return $saved_labels;
    }

    /**
     * @inheritDoc
     */
    public function deleteLabel(LabelDeleteRequest $request)
    {
        Label::query()
            ->where('id', $request->label_id)
            ->delete();
        
        // ラベルの並び順を振りなおす
        $this->resetLabelSortAll($request->binder_id);
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
            ->orderBy('sort')
            ->get();
        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function updateLabelSort(LabelSortRequest $request)
    {
        // NOTE: フロント側で並べ順変更リクエスト生成を共通化しているので「target_id」
        $label_id = $request->target_id;
        $target_label = Label::find($label_id);

        $binder_id = $request->binder_id;
        $sort_before = $target_label->sort;
        $sort_after = $request->sort_after;
 
        // 並び順を前方へ更新するかどうか(例：5 から 3)
        $is_forward_update = ($sort_after < $sort_before);

        if ($is_forward_update) {
            // レコードを前方に詰める
            $query = $this->getSortUpdateQueryForward(config('_const.TABLE_NAME.LABELS'));
            DB::update($query, [$binder_id, $sort_after, $sort_before]);

        } else {
            // レコードを後方に詰める
            $query = $this->getSortUpdateQueryBackward(config('_const.TABLE_NAME.LABELS'));
            DB::update($query, [$binder_id, $sort_before, $sort_after]);
        }

        // 対象の並び順を更新
        $target_label->sort = $sort_after;
        $target_label->save();
    }

    /**
     * @inheritdoc
     */
    public function updateBinderFavorite(BinderFavoriteRequest $request)
    {
        $user_id = Auth::id();
        $binderFavorite = BinderFavorite::query()
            ->where('user_id', $user_id)
            ->where('binder_id', $request->binder_id)
            ->first();
        
        if (empty($binderFavorite)) {
            // 未登録の場合は新規に登録
            $newBinderFavorite = new BinderFavorite([
                'user_id' => $user_id,
                'binder_id' => $request->binder_id
            ]);
            $newBinderFavorite->save();
        } else {
            // 登録済みの場合は解除
            $binderFavorite->delete();
        }
    }

    /**
     * 指定したラベルIDを持つ全てのラベルを削除します。
     * 
     * @param array $label_ids 削除対象のラベルID
     */
    private function deleteLabels($label_ids)
    {
        if (empty($label_ids) && count($label_ids) == 0) {
            return;
        }

        Label::query()
            ->whereIn('id', $label_ids)
            ->delete();
    }

    /**
     * 指定したバインダーに紐づくラベルを全て削除します。
     * NOTE/FIXME: CASCATE DELETEがラベルで動作しない
     */
    private function deleteLabelsAll($binder_id)
    {
        Label::query()
            ->where('binder_id', $binder_id)
            ->delete();
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

    /**
     * 指定したバインダーの全ラベルについて、並び順を連番で振りなおします。
     * NOTE: ラベル削除時に並び順を整理する
     * 
     * @param int $binder_id バインダーID
     */
    private function resetLabelSortAll($binder_id)
    {
        $query = $this->getSortResetQuery(config('_const.TABLE_NAME.LABELS'));
        DB::update($query, [$binder_id]);
    }

    /**
     * 指定したバインダーについて、全画像の並び順を一つ後ろへずらします。
     * NOTE: 新規に追加する画像の並び順は先頭(sort = 1)のため
     * 
     * @param int $binder_id バインダーID
     */
    private function shiftSortBackwordAll($binder_id)
    {
        // 新規追加画像の並び順
        $sort_after = 1;
        
        // <integerの最大値>から<0>へ並び順を更新する扱い
        $query = $this->getSortUpdateQueryForward(config('_const.TABLE_NAME.LABELS'));
        DB::update($query, [$binder_id, $sort_after, config('_const.MYSQL.INTEGER.MAX_VALUE')]);
    }

    /**
     * 指定したユーザーがアクセス可能なバインダーIDの一覧を返却します。
     * 
     * @param int $user_id ユーザーID
     */
    private function getAccesibleBinderIds($user_id)
    {
        return BinderAuthority::query()
            ->select('binder_id')
            ->where('user_id', $user_id)
            ->get();
    }

    /**
     * 自分が作成したバインダーかどうかという検索条件をクエリビルダへ設定します。
     *
     * @param Builder　$search_query 検索クエリビルダ
     * @param Request $request 
     */
    private function addSearchWhereOwn($search_query, $request)
    {
        if (empty($request->is_own) || !$request->is_own) {
            return;
        }

        $user_id = Auth::id();
        $search_query->where(function($query) use($user_id){
            $query->where('create_user_id', $user_id);
        });
    }

    /**
     * 他人が作成したバインダーかどうかという検索条件をクエリビルダに設定します。
     *
     * @param Builder　$search_query 検索クエリビルダ
     * @param Request $request 
     */
    private function addSearchWhereOthers($search_query, $request)
    {
        if (empty($request->is_other) || !$request->is_other) {
            return;
        }

        $user_id = Auth::id();
        $search_query->where(function($query) use($user_id){
            $query->where('create_user_id', '<>',  $user_id);
        });
    }
    
    /**
     * お気に入り登録したバインダーかどうかという検索条件をクエリビルダへ設定します。
     *
     * @param Builder　$search_query 検索クエリビルダ
     * @param Request $request 
     */
    private function addSearchWhereFavorite($search_query, $request)
    {
        if (empty($request->is_favorite) || !$request->is_favorite) {
            return;
        }

        $user_id = Auth::id();
        $favorite_binder_ids = BinderFavorite::query()
            ->select('binder_id')
            ->where('user_id', $user_id)
            ->get()
            ->pluck('binder_id');

        $search_query->where(function($query) use($favorite_binder_ids){
            $query->whereIn('id', $favorite_binder_ids);
        });
    }

    /**
     * バインダー名が前方一致するかどうかという検索条件をクエリビルダへ設定します。
     *
     * @param Builder　$search_query 検索クエリビルダ
     * @param Request $request 
     */
    private function addSearchWhereName($search_query, $request)
    {
        if (empty($request->binder_name)) {
            return;
        }

        $search_query->where(function($query) use($request) {
            $query->where('name', 'LIKE', "$request->binder_name%");
        });
    }
}
