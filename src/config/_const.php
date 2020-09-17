<?php

/**
 * 定数クラス
 */
return [
    'BINDER_AUTHORITY' => [// バインダー操作権限
        'LEVEL' => [// 権限レベル
            'GUEST' => 0,
            'MAINTAINER' => 10,
            'OWNER' => 50
        ],
    ],
    'IMAGE' => [// 画像
            'VISIBLE' => [
                    'HIDE' => 0,
                    'SHOW' => 1
            ]
    ],
    'HTTP_STATUS' => [// HTTPステータスコード
        'OK' => 200,
        'CREATED' => 201,
        'NO_CONTENT' => 204,
        'NOT_FOUND' => 404,
        'INTERNAL_SERVER_ERROR' => 500
    ],
    'UPLOAD_DIRECTORY' => [// ファイルアップロード先フォルダ名
            'BINDER' => 'image/binder',
            'USER' => 'image/user', // TODO: 実装予定
    ],
    'MYSQL' => [// MYSQL
        'INTEGER' => [
                'MAX_VALUE' => 2147483647
        ],
    ],
    'TABLE_NAME' => [// テーブル物理名
        'IMAGES' => 'images',
        'LABELS' => 'labels'
    ],
];