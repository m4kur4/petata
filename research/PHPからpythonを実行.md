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