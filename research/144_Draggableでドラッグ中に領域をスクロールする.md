### 対象画面
- バインダー
### 実装
- 画像をドラッグ中に領域外へ出た際、自動でスクロールされるようにする
### 参考
https://stackoverflow.com/questions/58505505/how-to-use-autoscroll-feature-vue-draggable


- computedにoptionを定義しないと上手くスクロールされない。
  - 試していないが要素のpropに直接設定してもOK
```js
computed: {
    dragOptions() {
      return {
        forceFallback: true
      };
    }
}
```