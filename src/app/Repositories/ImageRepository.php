<?php

namespace App\Repositories;

use App\Models\Image;
use App\Models\Labeling;
use App\Repositories\Interfaces\ImageRepositoryInterface;
use Illuminate\Http\File;
use App\Http\Requests\ImageAddRequest;
use App\Http\Requests\ImageDeleteRequest;
use App\Http\Requests\ImageRenameRequest;
use App\Http\Requests\ImageSortRequest;
use Intervention\Image\Facades\Image as InterventionImage;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Auth;
use DB;
use FileManageHelper;
use Log;
use Storage;

/**
 * @inheritdoc
 */
class ImageRepository implements ImageRepositoryInterface
{
    /**
     * @inheritdoc
     */
    public function search(Request $request)
    {
        // Log::debug('D0');
        // DB::enableQueryLog();
        $search_query = Image::query();

        $search_query->where('binder_id', $request->binder_id);

        // 検索条件の動的追加
        $this->addSearchWhereName($search_query, $request->image_name);
        $this->addSearchWhereLabel($search_query, $request->label_ids);

        $result = $search_query->get();

        // Log::debug(DB::getQueryLog());
        // Log::debug('/ D0');
        return $result;
    }

    /**
     * @inheritdoc
     */
    public function add(ImageAddRequest $request)
    {
        // TODO: バインダーを開いていない状態でアップロードさせない
        // $binder_id = Session::get('binder-id');
        // if (empty($binder_id)) {
        // }

        $original_name = $request->image->getClientOriginalName();
        $extension = $request->image->getClientOriginalExtension();

        $image = new Image([
            'binder_id' => $request->binder_id,
            'upload_user_id' => Auth::id(),
            'name' => str_replace(('.' . $extension) , '', $original_name), // 拡張子を除いたファイル名を設定
            'sort' => 0,
            'visible' => config('_const.IMAGE.VISIBLE.SHOW'),
            'extension' => $extension,
        ]);
        $image->save();

        // アップロード先："binder/<バインダーID>"
        $upload_directory = config('_const.UPLOAD_DIRECTORY.BINDER') . '/' . $request->binder_id;

        // pngへ変換した画像のアップロード
        $this->uploadPng($upload_directory, $request->image, $image->path);

        // オリジナル画像
        // TODO: S3を使う
        // $path = Storage::disk('s3')->putFileAs(
        $path = Storage::disk('public')->putFileAs(
            $upload_directory . '/org/', 
            $request->image, 
            ($image->path . '.' . $image->extension),
            'public'
        );
        return $path;
    }

    /**
     * @inheritdoc
     */
    public function addMany(ImageAddRequest $request)
    {
        // TODO: 実装

    }

    /**
     * @inheritdoc
     */
    public function delete(ImageDeleteRequest $request)
    {
        $image_query = Image::query()
            ->whereIn('id', $request->image_ids);
        
        $images = $image_query->get();

        // 削除対象のパスをまとめる
        $delete_target_paths = [];
        foreach($images as $image) {

            // クライアントから参照するpng画像
            $png_path = FileManageHelper::getBinderImageRelativePath($image, 'png');
            array_push($delete_target_paths, $png_path);
            
            // オリジナル画像
            $org_path = FileManageHelper::getBinderImageRelativePath($image);
            array_push($delete_target_paths, $org_path);

        }
        
        // TODO: データ削除に失敗した場合はファイルも消去しない
        $image_query->delete();

        // TODO: S3を使う
        // Storage::disk('s3')->delete($delete_target_paths);
        Storage::disk('public')->delete($delete_target_paths);
    }

    /**
     * @inheritdoc
     */
    public function removeMany(ImageDeleteRequest $request)
    {
        // TODO: 実装
    }

    /**
     * @inheritdoc
     */
    public function rename(ImageRenameRequest $request)
    {
        $image = Image::query()
            ->where('id', $request->id)
            ->first();
        
        $image->name = $request->name;
        $image->save();
    }

    /**
     * @inheritdoc
     */
    public function updateSort(ImageSortRequest $request)
    {
        $target_image = Image::find($request->image_id);

        $binder_id = $request->binder_id;
        $sort_before = $target_image->sort;
        $sort_after = $request->sort_after;
 
        // 並び順を前方へ更新(例：5 から 3)するかどうか
        $is_forward_update = ($sort_after < $sort_before);

        if ($is_forward_update) {
            // レコードを前方に詰める
            $query = $this->getSortUpdateQueryForward();
            DB::update($query, [$binder_id, $sort_after]);

        } else {
            // レコードを後方に詰める
            $query = $this->getSortUpdateQueryBackward();
            DB::update($query, [$binder_id, $sort_before, $sort_after]);
        }

        // 対象の並び順を更新
        $target_image->sort = $sort_after;
        $target_image->save();
    }

    /**
     * 並び順を【前方】に更新するSQL文を返却します。
     * 
     * @return string
     */
    private function getSortUpdateQueryForward()
    {
        // 関連するレコードを後ろへずらす
        $query_base = "
            UPDATE 
              images
            SET 
              sort = sort + 1
            WHERE 
              binder_id = ?
            AND
              sort >= ?;
        ";

        return $query_base;
    }

    /**
     * 並び順を【後方】に更新するSQL文を返却します。
     * 
     * @return string
     */
    private function getSortUpdateQueryBackward()
    {
        // 関連するレコードを前へずらす
        $query_base = "
            UPDATE 
              images
            SET 
              sort = sort - 1
            WHERE 
              binder_id = ?
            AND
              sort > ?
            AND
              sort <= ?;
        ";

        return $query_base;
    }

    /**
     * 名前の前方一致による検索条件をクエリビルダへ追加します。
     * 
     * @param Builder　$search_query 検索クエリビルダ
     * @param string $image_name 画像名
     * @return void
     */
    private function addSearchWhereName($search_query, $image_name)
    {
        if (empty($image_name)) {
            // 検索条件が設定されていない場合は処理なし
            return ;
        }
        $search_query->where(function($query) use($image_name) {
            $query->where('name', 'LIKE', "$image_name%");
        });
    }

    /**
     * ラベリングによる検索条件をクエリビルダへ設定します。
     *
     * @param Builder　$search_query 検索クエリビルダ
     * @param array $label_ids ラベルIDのリスト
     */
    private function addSearchWhereLabel($search_query, $label_ids)
    {
        if (empty($label_ids) || count($label_ids) == 0) {
            return;
        }

        // ラベリングされている画像IDを取得
        $image_ids = Labeling::query()
            ->select('image_id')
            ->whereIn('label_id', $label_ids)
            ->get()
            ->pluck('image_id');

        $search_query->where(function($query) use($image_ids) {
            $query->whereIn('id', $image_ids);
        });
    }

    /**
     * png形式に変換した画像をストレージへアップロードします。
     * NOTE: Async Clipborad APIで使用するためのファイル
     * 
     * @param string $upload_directory アップロード先
     * @param UploadedFile $file アップロードファイル
     * @param string $path 画像のパス属性
     */
    private function uploadPng($upload_directory, $file, $image_path)
    {
        // ファイルを変換するために一時ファイルをアップロードする
        $now = (Carbon::now())->format('Ymd');
        $temp_file_name = $now . '_' . $file->getClientOriginalName();
        $temp_path = storage_path('app/temp/') . $temp_file_name;

        InterventionImage::make($file)
            ->encode('png')
            ->save($temp_path);

        $image_png = new File($temp_path);

        // TODO: S3を使う
        // $path = Storage::disk('s3')->putFileAs(
        $path = Storage::disk('public')->putFileAs(
            $upload_directory, 
            $image_png, 
            ($image_path . '.' . 'png'),
            'public'
        );

        // 一時ファイルを削除
        Storage::disk('local')->delete('temp/' . $temp_file_name);
    }
}