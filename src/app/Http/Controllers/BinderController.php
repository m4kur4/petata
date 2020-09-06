<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinderSaveRequest;
use App\Http\Requests\LabelSaveRequest;
use App\Http\Requests\LabelingRequest;
use App\Http\Requests\LabelDeleteRequest;
use App\Services\Api\Interfaces\BinderCreateServiceInterface;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;
use App\Services\Api\Interfaces\BinderDetailSelectServiceInterface;
use App\Services\Api\Interfaces\LabelSaveServiceInterface;
use App\Services\Api\Interfaces\LabelingServiceInterface;
use App\Services\Api\Interfaces\LabelDeleteServiceInterface;

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
     * @param BinderCreateServiceInterface $binder_create_service ラベル作成サービス
     * @param BinderListSelectServiceInterface $binder_list_select_service ラベル一覧取得サービス
     * @param BinderDetailSelectServiceInterface $binder_detail_select_service ラベル詳細情報取得サービス
     * @param LabelSaveServiceInterface $label_save_service ラベル保存サービス
     * @param LabelDeleteServiceInterface $label_delete_service ラベル削除サービス
     * @param LabelingServiceInterface $labeling_service ラベリングサービス
     */
    public function __construct(
        BinderCreateServiceInterface $binder_create_service,
        BinderListSelectServiceInterface $binder_list_select_service,
        BinderDetailSelectServiceInterface $binder_detail_select_service,
        LabelSaveServiceInterface $label_save_service,
        LabelDeleteServiceInterface $label_delete_service,
        LabelingServiceInterface $labeling_service
    )
    {
        $this->binder_create_service = $binder_create_service;
        $this->binder_list_select_service = $binder_list_select_service;
        $this->binder_detail_select_service = $binder_detail_select_service;
        $this->label_save_service = $label_save_service;
        $this->label_delete_service = $label_delete_service;
        $this->labeling_service = $labeling_service;
        
        $this->middleware('auth');
    }

    /**
     * バインダーを作成します。
     * 作成後、ログインユーザーがアクセス可能なバインダーの一覧を返却します。
     *
     * @param BinderSaveRequest $request
     * @return Collection
     */    
    public function create(BinderSaveRequest $request)
    {
        try {
            $this->binder_create_service->execute($request);
            $binder_list= $this->binder_list_select_service->execute(Auth::id());
            
            return $binder_list;

        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
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
}
