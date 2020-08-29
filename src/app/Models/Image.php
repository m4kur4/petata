<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Image extends Model
{

    protected $fillable = [
        'binder_id',
        'upload_user_id',
        'name',
        'visible'
    ];

    /** ファイルパスの桁数 */
    const PATH_LENGTH = 12;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // 新規作成時、パスを設定する
        if (! Arr::get($this->attributes, 'id')) {
            $this->setPath();
        }
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
