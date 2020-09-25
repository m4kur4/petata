<?php

return [
    'VALIDATION' => [
        'IMAGE_ADD' => [
            'FILE_COUNT' => '1つのバインダーに保存可能なファイル数(30ファイル)を超えるため、アップロードできません。',
            'MAX_MB' => 'アップロード可能なサイズ(:max_in_mbMB)を超えたファイルが含まれています。',
            'FILE_EXTENSION' => 'アップロード可能な形式(.jpg/.png)以外のファイルが含まれています。'
        ],
        'SIGNUP' => [
            'DISABLED' => '現在、ユーザーの新規登録は凍結中です。',
        ],
    ]
];