### 複数のラベリングを同時に生成する処理を実装する
- 画像とラベルの掛け算になるので、一度のリクエストで完結させたい  
(正確には「選択中のラベルに関するラベリング全削除」のクエリと併せて2回)

### 参考
https://qiita.com/m-dove/items/18aef00ddcb0d1bad718
```php
$params = [
    ['first_name' => "tanaka", 'age' => 31, 'is_hungry' => 1 ],
    ['first_name' => "yamada", 'age' => 28, 'is_hungry' => 0 ]
]
DB::table('table-name')->insert($params);
```