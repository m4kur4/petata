<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinderCreateRequest;
use App\Http\Requests\LabelSaveRequest;
use App\Services\Api\Interfaces\BinderCreateServiceInterface;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;
use App\Services\Api\Interfaces\BinderDetailSelectServiceInterface;
use App\Services\Api\Interfaces\LabelSaveServiceInterface;

use App\Models\User;
use Illuminate\Http\Request;

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
     * @param BinderCreateServiceInterface $binder_create_service
     * @param BinderListSelectServiceInterface $binder_list_select_service
     * @param BinderDetailSelectServiceInterface $binder_detail_select_service
     * @param LabelSaveServiceInterface $label_save_service
     */
    public function __construct(
        BinderCreateServiceInterface $binder_create_service,
        BinderListSelectServiceInterface $binder_list_select_service,
        BinderDetailSelectServiceInterface $binder_detail_select_service,
        LabelSaveServiceInterface $label_save_service
    )
    {
        $this->binder_create_service = $binder_create_service;
        $this->binder_list_select_service = $binder_list_select_service;
        $this->binder_detail_select_service = $binder_detail_select_service;
        $this->label_save_service = $label_save_service;
        
        $this->middleware('auth');
    }

    /**
     * バインダーを作成します。
     * 作成後、ログインユーザーがアクセス可能なバインダーの一覧を返却します。
     *
     * @param BinderCreateRequest $request
     * @return Collection
     */    
    public function create(BinderCreateRequest $request)
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
            $response = response(['label' => $labels[0]], config('_const.HTTP_STATUS.OK'));
            return $response;

        } catch (\Exception $e) {
            Log::error($e);
            abort(config('_const.HTTP_STATUS.INTERNAL_SERVER_ERROR'));
        }
    }

    /**
     * ラベリングを行います。
     */
    public function labeling(LabelingRequest $request)
    {
        // TODO: チェック(フォームリクエスト)
        // - ログインユーザーのバインダーかどうか
        // - ログインユーザーの画像かどうか
        
    }
}
