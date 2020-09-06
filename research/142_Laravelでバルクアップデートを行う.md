### 対象画面
- バインダー
### 実装
- 画像の並び順を更新する際、複数のレコードに異なった値でUPDATEを行う
### 参考
https://stackoverflow.com/questions/51517262/laravel-bulk-update-for-multiple-record-ids
- クエリビルダの`update()`は「同じ値で複数レコードを更新する」処理しかサポートしていない
- foreach()でループする方法だと、レコード数分のクエリが発行されるのでNG
- 素のSQLを記述する必要がある。
```php

```