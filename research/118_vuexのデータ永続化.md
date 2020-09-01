### 対象画面
- 全画面
### 実装
- ページリロード時にstateのデータが消失する事象への対応  
※※※最終的に「ルートコンポーネントのマウント時、セッションからログインユーザー情報を再取得する」という対応をしたため、本調査結果は未使用

### 参考
- vuex-persistedstate
`npm install --save vuex-persistedstate`


- 参考  
https://qiita.com/chenglin/items/0fd9baf386227a5ca614  
https://www.webopixel.net/javascript/1463.html