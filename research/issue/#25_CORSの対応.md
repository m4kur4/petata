### S3バケットに許可設定をする
https://docs.aws.amazon.com/ja_jp/AmazonS3/latest/dev/cors.html#how-do-i-enable-cors
- アクセス権限>CORSの設定
  - CORS構成エディター
  - HEADは必須(アクセスが可能かどうかの前処理で使うらしい)  
  https://stackoverflow.com/questions/17533888/s3-access-control-allow-origin-header
  ```
    <CORSConfiguration>
    <CORSRule>
    <AllowedOrigin>https://petata.jp</AllowedOrigin>

    <AllowedMethod>HEAD</AllowedMethod>
    <AllowedMethod>GET</AllowedMethod>

    <AllowedHeader>*</AllowedHeader>
    </CORSRule>
    </CORSConfiguration>
  ```
  - ★★★ポリシー更新前からアップロードしているリソースには反映されないため注意
### 実装の修正
https://qiita.com/att55/items/2154a8aad8bf1409db2b
- `fetch()`のオプションを設定する。
```js
            const img = await fetch(image.src, {
                mode: 'cors',
            });
```
### CORSについて
https://qiita.com/att55/items/2154a8aad8bf1409db2b
- オリジン間リソース共有
- オリジン = ドメイン + ポート番号
  - 同一ドメインでもポート番号ごとに区別するということ
  - セキュリティポリシー(ホワイトリスト)として利用する概念
- リソース = Webコンテンツに対するアクセスをオリジン単位でアクセス制御することにより、  
意図しないコンテンツの配信や脆弱性を突いた攻撃を防止する。  
