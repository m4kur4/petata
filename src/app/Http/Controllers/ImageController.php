<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageDeleteRequest;
use App\Http\Requests\ImageRenameRequest;
use App\Models\Image;
use App\Services\Api\Interfaces\ImageAddServiceInterface;
use App\Services\Api\Interfaces\ImageDeleteServiceInterface;
use App\Services\Api\Interfaces\ImageSearchServiceInterface;
use App\Services\Api\Interfaces\ImageRenameServiceInterface;
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
     * @param ImageRenameServiceInterface $image_rename_service
     */
    public function __construct(
        ImageAddServiceInterface $image_add_service,
        ImageDeleteServiceInterface $image_delete_service,
        ImageSearchServiceInterface $image_search_service,
        ImageRenameServiceInterface $image_rename_service
    )
    {
        $this->image_add_service = $image_add_service;
        $this->image_delete_service = $image_delete_service;
        $this->image_search_service = $image_search_service;
        $this->image_rename_service = $image_rename_service;

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
     * 指定したIDを持つ画像情報を返却します。
     * 
     * @param string $image_id 画像ID
     * @return Response
     */
    public function detail($image_id)
    {
        // NOTE: ロジックを含まないので直接モデルを呼びだす
        $image = Image::find($image_id);
        $response = response(['image' => $image], config('_const.HTTP_STATUS.OK'));

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

    /**
     * 指定した画像をリネームします。
     */
    public function rename(ImageRenameRequest $request)
    {
        $this->image_rename_service->execute($request);

        $response = response([''], config('_const.HTTP_STATUS.OK'));

        return $response;
    }
}
