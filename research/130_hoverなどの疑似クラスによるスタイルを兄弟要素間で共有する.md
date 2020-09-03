### 対象画面
- バインダー
### 実装
- サムネイルへホバーしている際にサムネイル上のボタンを有効化する。
- ボタンを配置しているdiv要素へホバーしている間も、サムネイルへのホバーを切らない
### 参考
https://myscreate.com/pointer-events-tips/
- 親要素に`pointer-events:none;`
- 子要素(トリガー)に`pointer-events:auto;`
