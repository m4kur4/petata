## 環境構築
### コンテナの初回ビルド後、以下の作業が必要
#### 1. 環境変数の設定
- ".env.example"をコピーして".env"へリネーム
#### 2. 各種ライブラリのインストール
- petata_webコンテナに入って下記コマンドを実行
```bash
### アプリケーションキーの作成
$ composer update
$ php artisan key:generate

### Vue.jsのインストール
$ npm install
$ npm install -D vue
$ npm install -D vue-router
$ npm install -D vuex
$ npm audit fix

### cross-envのインストール
### (laravel-mixでコンパイル時にエラーが出るのでパスを通す必要がある)
$ npm install -D cross-env
```

## 詰まったこと
- npm run devで"cross-envがない"というエラー  
⇒node_modulesの中には居るが、パスを通すために個別でnpm installする。

- Cannot read property '$createElement' of undefined  
⇒ルーティングに記載するコンポーネントのキーは"components"ではなく"component"
  ```js
  const routes = [
    {
        path:'/',
        component: Test
    }
  ];
  ```

- コンポーネントの更新が反映されない  
⇒"Header.vue"というコンポーネントを"<header />"と呼び出していた
## その他メモ
### リソース
- MATERIAL COMPONENTS FOR THE WEB  
https://material-components.github.io/material-components-web-catalog/#/

### 技術
- SCSSの記法の基本  
https://qiita.com/nchhujimiyama/items/8a6aad5abead39d1352a
```
div {
    background: #666666;
    h1 {
        color: white;
    }
}
```
- マテリアルデザイン
  - 8の倍数
  
- Vue.jsのコンポーネント命名  
https://qiita.com/ngron/items/ab2a17ae483c95a2f15e

- SPAの利点  
https://www.oro.com/ja/technology/001/  
⇒今回開発では、以下の要件に対応
  - ネイティブアプリに相当する機能を提供
  - 直帰率が低い(作業中に開きっぱなしで操作する想定)
  - 高速(参考画像を切り替える手間を減らすアプローチ)

### 設定
- laravel-mixのコンパイル設定はwebpack.mix.jsで以下のように記述されている。  
コンパイル先の指定はここで行う。
```
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
```
