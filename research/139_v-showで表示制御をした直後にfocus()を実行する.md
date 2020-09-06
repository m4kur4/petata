### 対象画面
- バインダー
### 実装
- リストアイテムをクリックした際にファイル名編集のテキストエリアを有効化する
- 有効化は`v-show`とdataで行う
- 同一メソッド内でdataを更新して`focus()`を実行したところ、期待通りテキストエリアがフォーカスされない
```html
<textarea
    ref="fileNameEditForm"
    v-show="isEditMode"
    :id="`file-name-edit-${id}`"
    @keydown.enter="endEditFileName"
    @blur="endEditFileName"
></textarea>
```
```js
export default {
    data() {
        return {
            isEditMode: false
        };
    },
    props: {
        id: Number,
        imageSource: String,
        fileName: String
    },
    methods: {
        startEditFileName() {
            this.isEditMode = true;
            console.log("hogehoge");
            this.$refs.fileNameEditForm.focus();
        },
        endEditFileName() {
            this.isEditMode = false;
        }
    }
};
```
### 参考
https://stackoverflow.com/questions/45824797/set-focus-on-input-after-its-showed-by-v-show/45824866

- `nextTick`を使う
```js
    startEditFileName() {
      this.isEditMode = true;
      console.log("hogehoge");
      this.$nextTick(() => {
        this.$refs.fileNameEditForm.focus();
      });
```