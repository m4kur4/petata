<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

use FileManageHelper;

class Image extends Model
{

    protected $fillable = [
        'binder_id',
        'upload_user_id',
        'name',
        'visible',
        'extension'
    ];

    protected $visible = [
        'id',
        'binder_id',
        'upload_user_id',
        'name',
        'path',
        'visible',
        'storage_file_path'
    ];

    protected $appends = [
        'storage_file_path'
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
     * アクセサ - ストレージ上のファイルパス
     * NOTE: path列の値を絶対パス変換する
     */
    public function getStorageFilePathAttribute()
    {
        $storage_file_path = FileManageHelper::getBinderImagePath($this);
        return $storage_file_path;
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
