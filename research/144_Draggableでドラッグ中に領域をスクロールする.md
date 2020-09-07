### 対象画面
- バインダー
### 実装
- 画像をドラッグ中に領域外へ出た際、自動でスクロールされるようにする
### 参考
https://stackoverflow.com/questions/58505505/how-to-use-autoscroll-feature-vue-draggable

```js
<draggable [...]
           :force-fallback="true"
>
```
```js
    dragOptions() {
      return {
        forceFallback: true
      };
    }
```