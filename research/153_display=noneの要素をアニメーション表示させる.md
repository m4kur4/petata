※※※`v-show`とトランジションで解決した

### 対象画面
- ヘッダ
### 実装
- ユーザー名クリックでメニューを表示する
- 通常は`display:none`となっており、transitionが効かない
### 参考
https://qiita.com/saba_uni_toro_/items/6b0c3193bc50b5980fcf
- `@keyframes`と`animation`を使う
```scss
@keyframes usermenuShow {
    from {
        height: 0px;
      }
    
      to {
        height: 32px;
      }
}
[...]
        &.open {
            display: block;
            animation: usermenuShow 0.3s linear 0s;
        }
```
- `auto`にはtransitionが効かない
- animationの各プロパティ(http://www.htmq.com/css3/animation.shtml)

- 上記とは逆に`display:none`で隠すようにアニメーションさせる場合、  
`.hide`のように「隠れている状態」となるサブクラスを付与する必要がある。  
https://www.ipentec.com/document/css-animation-hide-shown-element
```scss
        &.hide {
            display: none;
            animation: usermenuHide 0.3s linear 0s;
        }
        &.open {
            display: block;
            animation: usermenuShow 0.3s linear 0s;
        }
```