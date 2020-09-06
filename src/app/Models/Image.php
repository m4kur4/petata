<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

use FileManageHelper;

use Log;

class Image extends Model
{

    protected $fillable = [
        'binder_id',
        'upload_user_id',
        'name',
        'visible',
        'extension',
        'sort'
    ];

    protected $visible = [
        'id',
        'binder_id',
        'upload_user_id',
        'name',
        'path',
        'visible',
        'storage_file_path',
        'storage_file_path_org',
        'labeling_label_ids'
    ];

    protected $appends = [
        'storage_file_path',
        'labeling_label_ids'
    ];

    /** ファイルパスの桁数 */
    const PATH_LENGTH = 24;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // 新規作成時、パスを設定する
        if (! Arr::get($this->attributes, 'id')) {
            $this->setPath();
        }
    }

    /**
     * リレーション - ラベル
     * 
     * ラベリングされているラベルを返却します。
     */
    public function labels() {
        return $this->belongsToMany(
            'App\Models\Label',
            'labelings',
            'image_id',
            'label_id'
        );
    }

    /**
     * アクセサ - ストレージ上のファイルパス(png形式画像)
     * NOTE: path列の値を絶対パス変換する
     */
    public function getStorageFilePathAttribute()
    {
        $storage_file_path = FileManageHelper::getBinderImagePath($this, 'png');

        return $storage_file_path;
    }

    /**
     * アクセサ - ストレージ上のファイルパス(オリジナル画像)
     * NOTE: path列の値を絶対パス変換する
     */
    public function getStorageFilePathOrgAttribute()
    {
        $storage_file_path_org = FileManageHelper::getBinderImagePath($this);
        return $storage_file_path_org;
    }

    /**
     * アクセサ - 画像とラベリングされているラベルIDのリスト
     * NOTE: path列の値を絶対パス変換する
     */
    public function getLabelingLabelIdsAttribute()
    {
        $labeling = $this->labels()->select('labels.id')->get();
        $label_ids = $labeling->pluck('id');
        return $label_ids;
    }

    /**
     * ランダムな文字列をパスに設定する
     */
    private function setPath()
    {
        $this->attributes['path'] = $this->getRandomId();
    }

    /**
     * ランダムなパスを生成する
     * @return string
     */
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);
        $id = "";

        for($i = 0; $i < self::PATH_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }
}
