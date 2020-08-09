#### グリッドレイアウト上の幅を自動調整する  
https://www.webprofessional.jp/difference-between-auto-fill-and-auto-fit/

#### グリッドレイアウト上のアイテムを中央揃えする  
https://developer.mozilla.org/ja/docs/Web/CSS/CSS_Grid_Layout/Box_Alignment_in_CSS_Grid_Layout
```
  align-self: center;
  justify-self: center;
```

#### スクロールバー非表示  
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
#### box-shadowが効かない
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

### 