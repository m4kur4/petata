### グリッドレイアウト上の幅を自動調整する  
https://www.webprofessional.jp/difference-between-auto-fill-and-auto-fit/

### グリッドレイアウト上のアイテムを中央揃えする  
https://developer.mozilla.org/ja/docs/Web/CSS/CSS_Grid_Layout/Box_Alignment_in_CSS_Grid_Layout
```
  align-self: center;
  justify-self: center;
```

### スクロールバー非表示  
https://www.yoheim.net/blog.php?q=20190801
```
<style>
    .container {
        height: 150px;
        overflow-y: scroll;
        -ms-overflow-style: none;    /* IE, Edge 対応 */
        scrollbar-width: none;       /* Firefox 対応 */
    }
    .container::-webkit-scrollbar {  /* Chrome, Safari 対応 */
        display:none;
    }
</style>
```
### box-shadowが効かない
- 後続の要素の背景色があったり画像がある場合は、  
box-shadowを設定する要素に`positon:relative`を指定する。  
https://xov.jp/e/815/

### 良い感じのやつ
- https://copypet.jp/692/

### 擬似クラス
- :hover  
マウスオーバー
- :nth-child(odd)  
奇数行
### 透明なボタン
- https://www.it-swarm.dev/ja/html/%E9%80%8F%E6%98%8E%E3%81%AAhtml%E3%83%9C%E3%82%BF%E3%83%B3%E3%82%92%E4%BD%9C%E3%82%8B%E3%81%AB%E3%81%AF%EF%BC%9F/1044756220/

### div要素を全体表示する
    - 親要素のhtml, bodyにスタイルを適用する必要がある
### SASSの変数
    - $hogehoge: 値;
### calc()と変数の併用  
参考：https://qiita.com/mtmtkzm/items/2e3aef1b504ebcde5311  
    - 変数を#{}で囲む
    - calcの仕様で四則演算子の前後には半角スペースが必要
    - 変数のスコープは入れ子のブロック(参考：https://maku77.github.io/sass/var.html)
- グリッドレイアウトの基本的な記述  
参考：https://qiita.com/kura07/items/e633b35e33e43240d363  
```
.container {
    display: grid;
    grid-template-rows: 100%;
    grid-template-columns: 192px 1fr;
    grid-template-areas: 
        "left-sidebar image-container";
    width: 100%;
    height: calc( 100% - #{$header-height} );
    &__left-sidebar {
        &--show {
            grid-area: left-sidebar;
            //border: 1px solid black;
            background-color:mediumaquamarine;
        }
        &--hidden {
            height: 100%;
            width: 10px;
            background-color: red;
        }
    }
}
```
### 動的にグリッドが増える場合は`grid-auto-〇〇`を使う。  
https://coliss.com/articles/build-websites/operation/css/difference-between-grid-template-and-grid-auto.html

### グリッドレイアウトの自動調整ライブラリ `Magic Grid`  
https://hiroshi-yokota.com/2020/01/23/magic-grid/