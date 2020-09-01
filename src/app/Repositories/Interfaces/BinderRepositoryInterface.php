<?php

namespace App\Repositories\Interfaces;

use App\Models\Binder;
use App\Models\Label;
use App\Http\Requests\BinderCreateRequest;

/**
 * バインダーリポジトリ
 */
interface BinderRepositoryInterface
{
    /**
     * バインダーを新規作成します。
     * 作成ユーザーには当該バインダーのオーナー権限を付与します。
     *
     * @param @param UserRegisterRequest $request
     */
    public function create(BinderCreateRequest $request);

    /**
     * 指定したIDを持つバインダーを削除します。
     * 対象のバインダーに関連する各種データも同時に削除します。
     *
     * @param string $binder_id
     * @return void
     */
    public function delete(string $binder_id);

    /**
     * 指定したユーザーIDに操作権限が付与されているバインダーを取得します。
     *
     * @param string $user_id
     * @return Collection
     */
    public function selectByAuthorizedUserId(string $user_id);

    /**
     * ユーザーへバインダーの操作権限を付与します。
     * 
     * @param string $user_id ユーザーID
     * @param string $binder_id バインダーID
     * @param int $level 権限レベル
     */
    public function addBinderAuthority($user_id, $binder_id, $level);
    
    /**
     * バインダーへラベルを追加します。
     * 追加したラベルのリストを返却します。
     *
     * @param string $binder_id バインダーID
     * @param array $label_posts POSTされたラベル情報
     * [
     *   'name' => ラベル名,
     *   'description' => ラベルの説明
     * ]
     * @return array(Label)
     */
    public function saveLabels(string $binder_id, ?array $label_posts);

    /**
     * バインダーの詳細情報を取得します。
     * 未ログイン、またはログインユーザーにアクセス権限がない場合はnullを返却します。
     * 
     * @param string $binder_id バインダーID
     * @return Binder
     */
    public function selectOneById(string $binder_id);

}