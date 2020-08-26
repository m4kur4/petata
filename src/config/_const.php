<?php

/**
 * 定数クラス
 */
return [
  // バインダー操作権限
  'BINDER_AUTHORITY' => [
    // 権限レベル
    'LEVEL' => [
      'GUEST' => 0,
      'MAINTAINER' => 10,
      'OWNER' => 50
    ],
  ],
  // 画像
  'IMAGE' => [
      'VISIBLE' => [
          'HIDE' => 0,
          'SHOW' => 1
      ]
  ],
];