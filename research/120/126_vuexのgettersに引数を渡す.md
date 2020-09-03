### 対象画面
- バインダー
### 実装
- 検索条件として参照するラベルIDの配列に条件が登録済みかどうかを判定する
### 参考
https://vuex.vuejs.org/ja/guide/getters.html  
- メソッドスタイルアクセス
```js
const getters = {
    /**
     * 指定したラベルIDが既にstateの検索条件へ追加されているかどうかを判定します。
     */
    isAlreadyAddSearchConditionLabel: (state) => (labelId) => {
        return state.search_condition.label_ids.includes(labelId);
    },
};
```
