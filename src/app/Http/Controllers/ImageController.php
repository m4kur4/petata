<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageDeleteRequest;
use App\Services\Api\Interfaces\ImageAddServiceInterface;
use App\Services\Api\Interfaces\ImageDeleteServiceInterface;
use App\Services\Api\Interfaces\ImageSearchServiceInterface;
use Illuminate\Http\Request;


use Log;

class ImageController extends Controller
{
    /**
     * コンストラクタ
     * 
     * @param ImageAddServiceInterface $image_add_service
     * @param ImageDeleteServiceInterface $image_delete_service
     * @param ImageSearchServiceInterface $image_search_service
     */
    public function __construct(
        ImageAddServiceInterface $image_add_service,
        ImageDeleteServiceInterface $image_delete_service,
        ImageSearchServiceInterface $image_search_service
    )
    {
        $this->image_add_service = $image_add_service;
        $this->image_delete_service = $image_delete_service;
        $this->image_search_service = $image_search_service;

        $this->middleware('auth');
    }

    /**
     * 画像をアップロードしてバインダーへ追加します。
     * アップロード先のファイルパスを返却します。
     * 
     * @param ImageAddRequest $request 画像追加リクエスト
     * @return Response
     */
    public function add(ImageAddRequest $request)
    {
        $response = $this->image_add_service->execute($request);
        return $response;
    }
    
    /**
     * バインダーに設定されている画像を、指定の検索条件で絞り込みます。
     * 
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $images = $this->image_search_service->execute($request);
        $response = response($images, config('_const.HTTP_STATUS.OK'));

        return $response;
    }

    /**
     * 指定した画像を削除します。
     * 削除後の画像のリストを返却します。
     */
    public function delete(ImageDeleteRequest $request)
    {
        $images = $this->image_delete_service->execute($request);

        $response = response($images, config('_const.HTTP_STATUS.OK'));

        return $response;
    }
}
