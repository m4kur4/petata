<?php

namespace App\Http\Controllers;

use App\Http\Requests\BinderCreateRequest;
use App\Services\Api\Interfaces\BinderCreateServiceInterface;
use App\Services\Api\Interfaces\BinderListSelectServiceInterface;

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
     */
    public function __construct(
        BinderCreateServiceInterface $binder_create_service,
        BinderListSelectServiceInterface $binder_list_select_service
    )
    {
        $this->binder_create_service = $binder_create_service;
        $this->binder_list_select_service = $binder_list_select_service;
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
            abort(500);
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

            Log::debug(Auth::id());
            Log::debug($binder_list->count());

            return $binder_list;

        } catch (\Exception $e) {
            Log::error($e);
            abort(500);
        }
    }

}
