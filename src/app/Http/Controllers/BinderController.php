<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinderSaveRequest;
use App\Http\Requests\BinderDeleteRequest;
use App\Http\Requests\BinderFavoriteRequest;
use App\Http\Requests\LabelSaveRequest;
use App\Http\Requests\LabelingRequest;
use App\Http\Requests\LabelDeleteRequest;
use App\Http\Requests\LabelSortRequest;
use App\Http\Requests\MultipleLabelingRequest;
use App\Services\Api\Interfaces\BinderSaveServiceInterface;
use App\Services\Api\Interfaces\BinderDeleteServiceInterface;
use App\Services\Api\Interfaces\BinderFavoriteServiceInterface;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;
use App\Services\Api\Interfaces\BinderSearchServiceInterface;
use App\Services\Api\Interfaces\BinderDetailSelectServiceInterface;
use App\Services\Api\Interfaces\LabelSaveServiceInterface;
use App\Services\Api\Interfaces\LabelingServiceInterface;
use App\Services\Api\Interfaces\LabelDeleteServiceInterface;
use App\Services\Api\Interfaces\LabelSortServiceInterface;
use App\Services\Api\Interfaces\MultipleLabelingServiceInterface;
use App\Models\User;

use Illuminate\Http\Request;

use App;
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
     * @param BinderListSelectServiceInterface $binder_list_select_service バインダー一覧取得サービス
     * @param BinderSearchServiceInterface $binder_search_service バインダー検索サービス
     * @param BinderDetailSelectServiceInterface $binder_detail_select_service バインダー詳細情報取得サービス
     * @param LabelSaveServiceInterface $label_save_service ラベル保存サービス
     * @param LabelDeleteServiceInterface $label_delete_service ラベル削除サービス
     * @param LabelSortServiceInterface $label_sort_service ラベル並び順更新サービス
     * @param LabelingServiceInterface $labeling_service ラベリングサービス
     * @param MultipleLabelingServiceInterface $multiple_labeling_service 一括ラベリングサービス
     */
    public function __construct(
        BinderSaveServiceInterface $binder_save_service,
        BinderDeleteServiceInterface $binder_delete_service,
        BinderFavoriteServiceInterface $binder_favorite_service,
        BinderListSelectServiceInterface $binder_list_select_service,
        BinderSearchServiceInterface $binder_search_service,
        BinderDetailSelectServiceInterface $binder_detail_select_service,
        LabelSaveServiceInterface $label_save_service,
        LabelDeleteServiceInterface $label_delete_service,
        LabelSortServiceInterface $label_sort_service,
        LabelingServiceInterface $labeling_service,
        MultipleLabelingServiceInterface $multiple_labeling_service
    )
    {
        $this->binder_save_service = $binder_save_service;
        $this->binder_delete_service = $binder_delete_service;
        $this->binder_favorite_service = $binder_favorite_service;
        $this->binder_list_select_service = $binder_list_select_service;
        $this->binder_search_service = $binder_search_service;
        $this->binder_detail_select_service = $binder_detail_select_service;
        $this->label_save_service = $label_save_service;
        $this->label_delete_service = $label_delete_service;
        $this->label_sort_service = $label_sort_service;
        $this->labeling_service = $labeling_service;
        $this->multiple_labeling_service = $multiple_labeling_service;
        
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
        $binder_list = $this->binder_delete_service->execute($request);
        $response = response(['biners' => $binder_list], config('_const.HTTP_STATUS.OK'));
        return $response;

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
     * バインダーを検索します。
     *
     * @return Collection
     */    
    public function search(Request $request)
    {
        try {
            $binders = $this->binder_search_service->execute($request);

            $response = response($binders, config('_const.HTTP_STATUS.OK'));
            return $response;

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
            if (empty($binder)) {
                // バインダーが見つからない場合は404を返却
                return response([], config('_const.HTTP_STATUS.NOT_FOUND'));
            }
            $response = response($binder, config('_const.HTTP_STATUS.OK'));
            return $response;

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
     * 一括ラベリングを行います。
     */
    public function labelingMany(MultipleLabelingRequest $request)
    {

        try {
            $this->multiple_labeling_service->execute($request);
            $response = response([], config('_const.HTTP_STATUS.CREATED'));
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
