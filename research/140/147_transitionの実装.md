### 参考
https://jp.vuejs.org/v2/guide/transitions.html#%E3%83%88%E3%83%A9%E3%83%B3%E3%82%B8%E3%82%B7%E3%83%A7%E3%83%B3%E3%82%AF%E3%83%A9%E3%82%B9

- 単体要素に適用する場合
- 複数要素に適用する場合

#### 単体要素に適用する場合
1. `<transition>`で囲う
2. 上記タグのname属性を指定する
3. <name>-leave-active のような規定のクラスが自動で付与される
  - v-if などの表示状態が変更された際に呼びだされるので、ここでトランジションのスタイルを適用すればOK

- 名前付きの例（名前が無い場合、`v-`という接頭辞のクラスになる)

- template
```vue
<template>
    <transition name="fade">
        <div
            v-if="isConnetcing"
            role="progressbar"
            class="progress-indicator mdc-linear-progress mdc-linear-progress--indeterminate"
        >
            [...]

        </div>
    </transition>
</template>
```

```scss
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
    opacity: 0;
}
```

#### 複数要素に適用する場合
- `<trasition-group>`を使う
  - Draggableにネストする記述でどはまりした。  
  次のような書き方をするとDraggableがtrasition-groupのタグにかかってしまう
  ```js
  <Draggable>
    <trasition-group></trasition-group>
    <Dropzone />
  </Draggable>
  ```
  - こうすれば解決した
  ```js
  <Draggable>
    <trasition-group></trasition-group>
  </Draggable>
  ```
- Draggableとtrasition-groupを併用する場合、  
trasition-group`だけ`が子要素に来るように記述しなければならない
- 参考：https://stackoverflow.com/questions/59260891/vue-draggable-dragging-wrong-element
```
The elements that you intend to be draggable should be direct children of draggable component or wrapped around with transition-group.
```