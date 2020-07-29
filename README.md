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