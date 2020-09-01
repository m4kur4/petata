### 対象画面
- バインダー
### 実装
- ドラッグ中の画像をdataTransfer.setDragImage()する際、  
getElementByIdなどを使用せずにコンポーネント内のDOMを参照したい。
### 参考
- https://designsupply-web.com/media/knowledgeside/5412/  
- `this.$el`(ルートコンポーネント)や`$refs`(コンポーネント内のDOM)を使う  
```vue
<template>
    <div
        @dragstart="dragStart($event)"
        @drag="drag($event)"
        class="image-container__thumbnail"
    >
        <img
            class="image-container__thumbnailImage mdc-elevation--z2"
            ref="thumbnailImage"
            :image-id="id"
            :id="`image-${id}`"
            :src="imageSource"
            :alt="fileName"
        />
    </div>
</template>
```
#### 最初は`ref="thumbnail-image"としていたが、ケバブケースは不可なのでキャメルケースにした。
```js
dragStart(event) {
    event.dataTransfer.setDragImage(this.$refs.thumbnailImage, 50, 50);
    event.dataTransfer.setData('image-id', this.id);
    console.log(this.id);
},
```
