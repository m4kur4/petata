### 対象画面
- バインダー
### 実装
- 画像削除時に並び順を振りなおす
- 一度のリクエストで複数のレコードを削除するため、「詰める」という動作が複雑になる
### 参考
https://qiita.com/yotsak/items/0c04883c4d67da31b35a
```sql
/**連番でUPDATEする*/
SET @i := 0;
UPDATE my_table SET id = (@i := @i +1)
```
1. 以下でエラー。直接SQLを叩くと通るので、update内でユーザー定義変数が使えない or 複数のクエリが実行できない？
```php
        $query_base = "
            SET @i := 0;
            UPDATE 
              images
            SET 
              sort = (@i := @i + 1)
            WHERE 
              binder_id = ?
            ORDER BY 
              sort DESC;
        ";
        DB::update($query_base, [$binder_id]);
```
2. 以下を試す
- 画面からなら処理OK
  - テストはSQLiteなのでNG
```php
        $query_prepare = '
            SET @i := 0;
        ';
        DB::statement($query_prepare);
        $query_update = '
            UPDATE 
              images
            SET 
              sort = (@i := @i + 1)
            WHERE 
              binder_id = ?
            ORDER BY 
              sort DESC;
        ';
        DB::update($query_update, [$binder_id]);
```
- だめ
  - SQLiteなのでNG
```log
testing.ERROR: SQLSTATE[HY000]: General error: 1 near "SET": syntax error (SQL: 
            SET @i := 0;
        ) {"userId":1,"exception":"[object] (Illuminate\\Database\\QueryException(code: HY000): SQLSTATE[HY000]: General error: 1 near \"SET\": syntax error (SQL: 
            SET @i := 0;
        ) at /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connection.php:669)
```
## テスト用DBはSQLiteなのでMYSQLのユーザー定義変数は使えないだけ
- [1]は画面から実行してもエラー
  - 一つのメソッド内で複数のクエリは不可
  - またはDB::statementでないと`SET`が使えない
```log
[2020-09-07 04:40:22] local.ERROR: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'UPDATE 
              images
            SET 
              sort = (@i := @i ' at line 2 (SQL: 
            SET @i := 0;
            UPDATE 
              images
            SET 
              sort = (@i := @i + 1)
            WHERE 
              binder_id = 1
            ORDER BY 
              sort DESC;
        ) {"userId":1,"exception":"[object] (Illuminate\\Database\\QueryException(code: 42000): SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'UPDATE 
              images
            SET 
              sort = (@i := @i ' at line 2 (SQL: 
            SET @i := 0;
            UPDATE 
              images
            SET 
              sort = (@i := @i + 1)
            WHERE 
              binder_id = 1
            ORDER BY 
              sort DESC;
        ) at /var/www/html/vendor/laravel/framework/src/Illuminate/Database/Connection.php:669)
```

