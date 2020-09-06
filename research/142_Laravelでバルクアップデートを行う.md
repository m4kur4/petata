### 対象画面
- バインダー
### 実装
- 画像の並び順を更新する際、複数のレコードに異なった値でUPDATEを行う
### 参考
https://stackoverflow.com/questions/51517262/laravel-bulk-update-for-multiple-record-ids
- クエリビルダの`update()`は「同じ値で複数レコードを更新する」処理しかサポートしていない
- foreach()でループする方法だと、レコード数分のクエリが発行されるのでNG
- 素のSQLを記述する必要がある。
https://qiita.com/Yorinton/items/3d2e3c283b4cd8dbc955  

```php
DB::select("SELECT * FROM users");
DB::selectOne("SELECT * FROM users WHERE id = ?", [1]);
DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
DB::update('update users set votes = 100 where name = ?', ['John']);
DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
DB::update('update users set votes = 100 where name = ?', ['John']);
DB::delete('delete from users WHERE id = ?' [1]);
DB::statement('drop table users');
DB::statement('alter table users auto_increment = 1');
```