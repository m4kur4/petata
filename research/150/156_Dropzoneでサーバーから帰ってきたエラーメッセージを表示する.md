### 調査

- Dropzone はサーバーからのレスポンスを次のように受け取る

```js
dropzoneOptions: {
    [...]
    error: function(file, response) {

        // エラーメッセージの表示
        const errorMessages = response.errors.images.map(text => {
            // 通知メッセージのフォーマットへレスポンスを変換
            const messages = util.createMessage(
                text,
                MESSAGE_TYPE.ERROR
            );
        });
        this.$store.dispatch("messageBox/addMany", errorMessages);
    },
```
- 2ファイルでエラーを起こした場合、フォーマットは以下(response.errors)
  - アクセスは`response.errors["images.0"]`
  - 展開して一覧表示する必要がある。
  - 重複したメッセージは削除する(多数のファイルをアップロードしてエラーになると画面が埋まる)
```
{images.0: Array(1), images.1: Array(1)}
    images.0: Array(1)
        0: "The images.0 may not be greater than 5 kilobytes."
        length: 1
    images.1: Array(1)
        0: "The images.1 may not be greater than 5 kilobytes."
        length: 1
```
### 実装
- 型は`object`
```js
typeof response.errors
>>"object"
```
1. Object.values()で「配列の配列」を作る
```js
// ↓なぜかできない
const values = response.errors.values();
/**
VM24126:1 Uncaught TypeError: response.errors.values is not a function
    at eval (eval at error (app.js:3169), <anonymous>:1:24)
    at o.error (app.js:3169)
    at o.value (app.js:57374)
    at o.value (app.js:57374)
    at o.value (app.js:57374)
    at o.value (app.js:57374)
    at XMLHttpRequest.n.onload (app.js:57374)
*/
// ↓こちらが正しい
const values = Object.values(response.errors);
/*
0: ["The images.0 may not be greater than 5 kilobytes."]
1: ["The images.1 may not be greater than 5 kilobytes."]
length: 2
*/
```
2. 配列を展開する
```js
const flatten = values.flat(1)
//(2) ["The images.0 may not be greater than 5 kilobytes.", "The images.1 may not be greater than 5 kilobytes."]
```
3. 重複を削除する(画像関係のバリデーションメッセージは項目名を入れないので同一になる)
- 参考⇒https://qiita.com/Nossa/items/e6f503cbb95c8e6967f8
```js
const converted = [...(new Set(flatten))];
```
- ワンライナーでまとめると`[...new Set(Object.values(response.errors).flat(1))]`
