### 対象画面
- バインダー
### 実装
- 以下を併用してラベルの検索条件追加状態を取得するcomputedを定義する
  - コンポーネントから引数を渡すgetters（メソッドアクセススタイル）
  - 名前付きstoreのgettersを使用する

### 参考
https://stackoverflow.com/questions/48400324/how-to-use-vuex-namespaced-getters-with-arguments

- やっていることは「gettersで関数を返してコンポーネント側で実行」
  - 引数を取らないgettersは()を付けない  
  ※別ページで引っかかった  
  `return this.$store.getters["binderCreate/isNewBinder"];`

```js
/**
 * 自身のラベルIDがstateの検索条件へ追加されているかどうか
 */
isAddSearchCondition() {
    return this.$store.getters["binder/isAlreadyAddSearchConditionLabel"](
        this.id
    );
}
```