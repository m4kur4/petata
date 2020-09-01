### 対象画面
- バインダー
### 実装
- D&Dによるラベリング
### 参考
- https://reffect.co.jp/vue/vue-js-drag-drop-columns
- ドラッグする要素(画像)
```js
/**
 * ラベリング実行のためのドラッグイベントです。
 * NOTE: ドロップ時、dataTransfer.getData('image-id')で画像のIDを取得
 */
dragStart(event) {
    event.dataTransfer.setDragImage(this.$refs.thumbnailImage, 50, 50);
    event.dataTransfer.setData('image-id', this.id);
    console.log(this.id);
},
```
- ドラッグ先(ラベル)
```js
drop(event) {
    const imageId = event.dataTransfer.getData('image-id');
    const labelId = this.id;
    alert(`${imageId}と${labelId}を組みあわせるよ...!`);
}
```