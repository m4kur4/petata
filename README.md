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
```