#### 1. AWS側の設定  
参考：https://qiita.com/nobu0717/items/4425c02157bc5e88d7b6  
- AmazonS3FullAccessの権限を持ったIAMユーザーを作成
    - 認証情報、コンソールログイン情報のCSVをダウンロードしておく
- S3バケットを作成
- バケットポリシーの追加
    - ユーザーのARN  
    ARNとは？  
    ⇒Amazon Resource Name  
    ⇒Amazonのリソースを一意に特定するキー値  
    ⇒これをバケットのポリシーの「ARN」という設定をすることで、  
    今回作成したIAMユーザーだけがアクセス可能とする
    - ポリシージェネレータで「ユーザーのARN」「バケットのARN」からポリシーを作成し、  
    バケットのポリシーへ登録する。
- .envに設定を記述

#### 2. laravel側の設定
参考：https://qiita.com/nobu0717/items/51dfcecda90d3c5958b8  

- パッケージのインストール
- コンフィグファイルの設定  

⇒laravel6ではデフォルトで設定済みかもしれない。

#### 3. 実装

- Storageファサードでs3を指定して実装
