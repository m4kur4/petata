<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinderSaveRequest;
use App\Http\Requests\BinderDeleteRequest;
use App\Http\Requests\BinderFavoriteRequest;
use App\Http\Requests\LabelSaveRequest;
use App\Http\Requests\LabelingRequest;
use App\Http\Requests\LabelDeleteRequest;
use App\Http\Requests\LabelSortRequest;
use App\Services\Api\Interfaces\BinderSaveServiceInterface;
use App\Services\Api\Interfaces\BinderDeleteServiceInterface;
use App\Services\Api\Interfaces\BinderFavoriteServiceInterface;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;
use App\Services\Api\Interfaces\BinderDetailSelectServiceInterface;
use App\Services\Api\Interfaces\LabelSaveServiceInterface;
use App\Services\Api\Interfaces\LabelingServiceInterface;
use App\Services\Api\Interfaces\LabelDeleteServiceInterface;
use App\Services\Api\Interfaces\LabelSortServiceInterface;

use App\Models\User;

use Auth;
use Log;

/**
 * バインダーコントローラー
 */
class BinderController extends Controller
{
    /**
     * コンストラクタ
     * 
     * @param BinderSaveServiceInterface $binder_save_service バインダー作成サービス
     * @param BinderDeleteServiceInterface $binder_delete_service バインダー削除サービス
     * @param BinderFavoriteServiceInterface $binder_favorite_service バインダーお気に入りサービス
     * @param BinderListSelectServiceInterface $binder_list_select_service ラベル一覧取得サービス
     * @param BinderDetailSelectServiceInterface $binder_detail_select_service ラベル詳細情報取得サービス
     * @param LabelSaveServiceInterface $label_save_service ラベル保存サービス
     * @param LabelDeleteServiceInterface $label_delete_service ラベル削除サービス
     * @param LabelSortServiceInterface $label_sort_service ラベル並び順更新サービス
     * @param LabelingServiceInterface $labeling_service ラベリングサービス
     */
    public function __construct(
        BinderSaveServiceInterface $binder_save_service,
        BinderDeleteServiceInterface $binder_delete_service,
        BinderFavoriteServiceInterface $binder_favorite_service,
        BinderListSelectServiceInterface $binder_list_select_service,
        BinderDetailSelectServiceInterface $binder_detail_select_service,
        LabelSaveServiceInterface $label_save_service,
        LabelDeleteServiceInterface $label_delete_service,
        LabelSortServiceInterface $label_sort_service,
        LabelingServiceInterface $labeling_service
    )
    {
        $this->binder_save_service = $binder_save_service;
        $this->binder_delete_service = $binder_delete_service;
        $this->binder_favorite_service = $binder_favorite_service;
        $this->binder_list_select_service = $binder_list_select_service;
        $this->binder_detail_select_service = $binder_detail_select_service;
        $this->label_save_service = $label_save_service;
        $this->label_delete_service = $label_delete_service;
        $this->label_sort_service = $label_sort_service;
        $this->labeling_service = $labeling_service;
        
        $this->middleware('auth');
    }

    /**
     * バインダーを保存します。
     * 作成後、ログインユーザーがアクセス可能なバインダーの一覧を返却します。
     *
     * @param BinderSaveRequest $request
     * @return Collection
     */    
    public function save(BinderSaveRequest $request)
    {
        try {
            $this->binder_save_service->execute($request);
            $binder_list= $this->binder_list_select_service->execute(Auth::id());
            
            return $binder_list;

        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
    }

    /**
     * バインダーを削除します。
     * 削除後、ログインユーザーがアクセス可能なバインダーの一覧を返却します。
     *
     * @param BinderSaveRequest $request
     * @return Collection
     */    
    public function delete(BinderDeleteRequest $request)
    {
        Log::debug('D0');
        Log::debug($request);
        Log::debug('/ D0');

        $this->binder_delete_service->execute($request);
    }

    /**
     * ログインユーザーがアクセス可能なバインダーの一覧を返却します。
     *
     * @return Collection
     */    
    public function list()
    {
        try {
            $binder_list= $this->binder_list_select_service->execute(Auth::id());

            return $binder_list;

        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
    }

    /**
     * 指定したバインダーIDを持つバインダー情報を取得します。
     * 
     * @param string $binder_id バインダーID
     */
    public function detail($binder_id)
    {
        try {
            $binder= $this->binder_detail_select_service->execute($binder_id);
            return $binder;

        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
    }

    /**
     * ラベル情報を保存します。
     */
    public function saveLabel(LabelSaveRequest $request)
    {
        try {
            $labels = $this->label_save_service->execute($request);
            $response = response(['labels' => $labels], config('_const.HTTP_STATUS.OK'));
            return $response;

        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
    }

    /**
     * ラベル情報を削除します。
     */
    public function deleteLabel(LabelDeleteRequest $request)
    {
        $labels = $this->label_delete_service->execute($request);
        $response = response($labels, config('_const.HTTP_STATUS.OK'));

        return $response;
    }

    /**
     * ラベリングを行います。
     */
    public function labeling(LabelingRequest $request)
    {
        // TODO: チェック(フォームリクエスト)
        // - ログインユーザーのバインダーにあるラベルかどうか
        // - ログインユーザーの画像かどうか
        // - 存在するラベルかどうか
        // - 存在する画像かどうか
        
        try {
            $status_code = $this->labeling_service->execute($request);
            
            $response = response([''], $status_code);
            return $response;

        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
    }

    /**
     * ラベルの並び順を更新します。
     * 
     * @param LabelSortRequest $request
     */
    public function sortLabel(LabelSortRequest $request)
    {
        $labels = $this->label_sort_service->execute($request);

        $response = response(['labels' => $labels], config('_const.HTTP_STATUS.OK'));
        return $response;
    }

    /**
     * ログインユーザーのバインダーお気に入り状態を切り替えます。
     * 
     * @param BinderFavoriteRequest $request
     */
    public function favorite(BinderFavoriteRequest $request)
    {
        try {
            $this->binder_favorite_service->execute($request);

            $response = response([
                'binder_id' => $request->binder_id,
                'is_favorite' => !$request->is_favorite
            ], config('_const.HTTP_STATUS.OK'));

            return $response;
            
        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
    }
}
