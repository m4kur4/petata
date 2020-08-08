### 基本
https://www.php.net/manual/ja/function.exec.php

### ユーザー入力に対するエスケープなど
https://www.php.net/manual/ja/function.exec.php

### PHPのOSコマンド呼び出し
- ドキュメントルート外のファイルを参照したい
  - exec("cd")は不可
    - `chdir`を使う
- こんな感じで実装できた
```php
// $output[0]にドキュメントルートディレクトリが格納/var/www/html/public
exec("pwd", $output);
// カレントディレクトリ移動
chdir('../_python');
// $output[1]にpythonスクリプト実行結果が格納
exec("python3 hello.py", $output);
```


### pythonから環境変数の参照
- `os.environ(<key>)`
  - `.env`で設定している値は、サーバーが立ち上がっていないと参照できない。  
  (サーバーが経っていない状態のコンテナで直接スクリプトを叩いても「環境変数が存在しない」エラー)  
  API経由で実行した場合は正常に読み込めた。