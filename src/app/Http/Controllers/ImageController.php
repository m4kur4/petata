<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageAddRequest;
use App\Services\Api\Interfaces\ImageAddServiceInterface;

use Log;

class ImageController extends Controller
{
    /**
     * コンストラクタ
     * 
     * @param ImageAddServiceInterface $image_add_service
     */
    public function __construct(
        ImageAddServiceInterface $image_add_service
    )
    {
        $this->image_add_service = $image_add_service;
    }


    /**
     * 画像をアップロードしてバインダーへ追加します。
     * アップロード先のファイルパスを返却します。
     * 
     * @param ImageAddRequest $request 画像追加リクエスト
     * @return json
     */
    public function add(ImageAddRequest $request)
    {
        Log::debug('D1');
        Log::debug($request);
        Log::debug('/ D1');
        $response = $this->image_add_service->execute($request);
        return $response;
    }
}
