- tooltip内に別のコンポーネントを埋め込みたい場合に利用する
- バインダータイトルで利用しようとした実装は以下のような感じ
  - <v-popover>で対象要素をラップする
```vue
<template>
    [...]
                <v-popover 
                    :trigger="'hover'"
                    :placement="'bottom'"
                >
                    <!-- ここに対象要素を記述 -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="24"
                        viewBox="0 0 24 24"
                        width="24"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"
                        />
                    </svg>
                    <!-- 以下にコンポーネントなどをスロットできる -->
                    <template slot="popover">
                        <input
                            class="tooltip-content"
                            placeholder="Tooltip content"
                        />
                        <p>
                            hogehoge
                        </p>
                    </template>
                </v-popover>
    [...]
</template>
```
#### ※※未解決
- `v-tooltip`のように「出現させる方向」が指定できない。
- 結局こうした
  - バインダーの説明があればツールチップに追加
  - バインダーの説明内にある改行文字をbrタグへ置換
```js
v-tooltip.right="{
    content: `[${binder.created_at} -]${
        !!binder.description
            ? '<br>' +
              binder.description.replace(/\n/g, '<br>')
            : ''
    }`
}"
```