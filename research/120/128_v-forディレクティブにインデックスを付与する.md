### 対象画面
- バインダー作成

### 実装
- 編集・削除対象ラベルの識別

### 参考
http://clue-design.com/vue/v-for-index

```js
HTML（Vue.js CSSを操作して、スタイルを動的に設定する（v-bind:style））Default
<div id="app">
  <p v-for="(item, index) in items">
    {{index + 1}} : {{item.name}} : {{item.price}}
  </p>
</div>
```