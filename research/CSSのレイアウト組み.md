#### 1. 考え方
- グリッドレイアウト
#### 2. CSS
##### BEM記法
- .containerを全体表示させられなくて若干詰まった。
    - 親要素のhtml, bodyにスタイルを適用する必要があった。
- SASSの変数
    - $hogehoge: 値;
- calc()と変数の併用  
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
- 動的にグリッドが増える場合は`grid-auto-〇〇`を使う。  
https://coliss.com/articles/build-websites/operation/css/difference-between-grid-template-and-grid-auto.html

- ライブラリがあった。`Magic Grid`  
https://hiroshi-yokota.com/2020/01/23/magic-grid/