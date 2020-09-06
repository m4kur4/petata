### 対象画面
- バインダー
### 実装
- Draggableのendイベントで並び順の永続化を行う
- 必要なパラメタは以下
  - バインダーのID
  - 移動した画像のID
  - 「移動後の位置の一つ手前にある画像」の並び順

### 調査
- `event.item`でDOMを取得できるので、ユーザー定義の属性経由で画像IDを取得する。
```js
const imageId = event.item.getAttribute("image-id");
```