<?php

namespace App\Repositories\Interfaces;

use App\Models\Binder;
use App\Models\Label;
use App\Http\Requests\BinderSaveRequest;
use App\Http\Requests\LabelingRequest;
use App\Http\Requests\LabelDeleteRequest;
use App\Http\Requests\LabelSortRequest;

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
    public function create(BinderSaveRequest $request);

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
     * バインダーへラベルを保存します。
     * 保存後のラベルのリストを返却します。
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
     * ラベルを削除します。
     * 
     * @param LabelDeleteRequest $request
     */
    public function deleteLabel(LabelDeleteRequest $request);

    /**
     * バインダーの詳細情報を取得します。
     * 未ログイン、またはログインユーザーにアクセス権限がない場合はnullを返却します。
     * 
     * @param string $binder_id バインダーID
     * @return Binder
     */
    public function selectOneById(string $binder_id);

    /**
     * 指定したラベルと画像の組み合わせでラベリングが存在するかを判定します。
     * 
     * @param string $label_id ラベルID
     * @param string $image_id 画像ID
     */
    public function isExistLabeling($label_id, $image_id);

    /**
     * 指定したラベルと画像の組み合わせでラベリングを新規登録します。
     * 
     * @param LabelingRequest $request
     */
    public function addLabeling(LabelingRequest $request);

    /**
     * 指定したラベルと画像の組み合わせで登録されているラベリングを解除します。
     * 
     * @param LabelingRequest $request
     */
    public function deleteLabeling(LabelingRequest $request);

    /**
     * 指定したバインダーに紐づくラベルのリストを返却します。
     * 
     * @param int $binder_id バインダーID
     */
    public function selectLabelsRelatedToBinder(string $binder_id);

    /**
     * ラベルの並び順を更新します。
     * 
     * @param LabelSortRequest $request
     */
    public function updateLabelSort(LabelSortRequest $request);

}