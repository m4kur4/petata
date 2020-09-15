### ドメインのネームサーバー反映確認
https://www.cman.jp/network/support/nslookup.html

### そもそもの`https`プロトコル
https://www.kagoya.jp/howto/rentalserver/ssl/
- HTTP + Secure
- HTTP通信を暗号化してセキュリティを強化する
  - SSL/TLSを用いる

#### SSL/TLS
C: クライアント / S: サーバー
1. C ⇔ 暗号化仕様の合意 ⇔ S
2. C ← [公開鍵 + サーバー証明書] ← S ... 正しいサーバーであることを保証
3. C → [公開鍵で暗号化した共通鍵] → S ... C/S以外で共通鍵が利用されない事を保証
4. C ⇔ [3で共有した共通鍵で暗号化したデータ] ⇔ S ... 通信内容が盗聴・改ざんされない事を保証

- 2,3は鍵交換、4が本番の通信
- 全てを共通鍵方式でやろうとすると、サーバーは通信相手となる全クライアント分の鍵を管理しなければならない
  - 現実的ではないので、サーバーの公開鍵を配布するだけで済む公開鍵方式を採用している
- 公開鍵方式は遅いので、ハンドシェイクだけ公開鍵方式でそれ以降は共通鍵方式としている
  - そのため、公開鍵方式で複合鍵となる共通鍵を共有というシーケンスになる

### 方法
https://knowledge.sakura.ad.jp/10534/
https://www.virment.com/how-to-get-wildcard-certificate-lets-encrypt/
#### サーバー証明書を用意する
- Let's Encryptについて  
  https://www.slideshare.net/hourin/30lets-encryptssl
  - 証明書を自動発行してくれる
  - ACMEプロトコル = WebサーバーとCAの間で使うプロトコル

##### 作業履歴
- ルートユーザーへ切り替え
  - `$ su -`
- mod_ssl(ApacheのSSLモジュール)をインストール
  - `$ httpd -M`でmod_sslがないことを確認
    - `$ yum install mod_ssl`でインストール
    - 再度`$ httpd -M`を叩きインストールを確認  
      `>> ssl_module (shared)`
- `$ firewall-cmd --list-all`で443番ポートが許可されていることを確認  
   `>> services: dhcpv6-client http https ssh`
- Let’s Encryptをインストール
  - `$ yum install certbot python2-certbot-apache`
- 証明書のインストール
  - `$ certbot --apache -d <ドメイン名>`
    - メールアドレス
    - 規約に同意(A/C)
    - Let’s Encryptへのメールアドレス公開可否(Y/N)
- ここでエラー
```
Unable to find a virtual host listening on port 80 which is currently needed for Certbot to prove to the CA that you control your domain. Please add a virtual host for port 80.

IMPORTANT NOTES:
 - Your account credentials have been saved in your Certbot
   configuration directory at /etc/letsencrypt. You should make a
   secure backup of this folder now. This configuration directory will
   also contain certificates and private keys obtained by Certbot so
   making regular backups of this folder is ideal.
```
  - パケットフィルタリングを外した
    - 効果なし
  - 仮想ホストのポート80番を追加する必要がある模様  
  https://freepc.jp/encrypt
    - `etc/httpd/conf/httpd.conf`へ以下を記述
    ```
    NameVirtualHost *:80

    <VirtualHost *:80>
    ServerAdmin root@<ドメイン名>
    DocumentRoot /var/www/html
    ServerName <ドメイン名>
    </VirtualHost>
    ```
    - 仮想ホストとは？
      - Apacheの機能
      - 1つのWebサーバーで複数のホスト名を運用するための仕組み
      - TODO: なぜサーバー証明書のインストールで仮想ホストが必要なのか？？
        - SSL通信を行うプロセスを別途用意するため(?)

  - 成功  
    - `>>Congratulations! You have successfully enabled https://<ドメイン名>`
- Apacheを再起動
  - `$ systemctl restart httpd`

- サービスに外部からアクセスしてssl化されていることを確認
  - エラーが出るようになってしまった
  ```
  Mixed Content: The page at 'https://<IPアドレス>/signin' was loaded over HTTPS, but requested an insecure XMLHttpRequest endpoint 'http://api/user/info'. This request has been blocked; the content must be served over HTTPS.
  ```
    - サイトがSSL化されているのにAPIがされていない？
  - Laravel側でやることがある  
  https://qiita.com/Yorinton/items/50b9c8e3102ac661f08c
    - HTTP接続をすべてHTTPSへリダイレクトさせる
    - URLを全てHTTPSへ変更
      - `api.php`では特にプロトコルを指定していない。
      - axiosのベースURLを.envで定義しているので書き換える
      ```
      APP_URL=https://
      MIX_APP_URL=https://
      ```
        - 反映されない
        - laravelのキャッシュをクリアしてサーバーを再起動(`$ sudo systemctl reboot`)  
        →だめ
        - コンソールからbootstrap.jsを確認  
          - ★★★コンパイルしていない★★★
          - `npm run dev`で読み込めた
    - 今度はSSL化したドメイン名でドキュメントルートへアクセスできない
      - var/www/htmlを参照している模様(同ディレクトリに置いてるindex.phpを開いてる)
      - 先程のバーチャルホストが関係している？？
      - SSL化する通信用の仮想ホスト+ポートを用意し、そこに対して証明書を用いた通信が適用される？  
      →ちがうらしい(https通信でドキュメントルートの設定が反映されない：後述)
    - httpd.confの設定を見直す
      - 仮想ホストのドキュメントルートを修正する
      - Apache再起動
      - 反映されない
        - 検索したら同じ事象の記事があった
        https://qiita.com/ZAKILOG1/items/9b171b28e69afc9063bf
        - 443番ポート用の仮想ホストを定義する必要がある
        - 以下を`httpd.conf`へ追記
        ```
        <VirtualHost *:443>
        ServerAdmin root@<ドメイン名>
        ServerName <ドメイン名>
        DocumentRoot "<ドキュメントルート>"
        SSLEngine on
        SSLCertificateFile /etc/letsencrypt/live/<ドメイン名>/cert.pem
        SSLCertificateKeyFile /etc/letsencrypt/live/<ドメイン名>/privkey.pem
        SSLCertificateChainFile /etc/letsencrypt/live/<ドメイン名>/chain.pem
        <Directory "<ドキュメントルート>">
            Options Indexes FollowSymLinks
            AllowOverride ALL
            Require all granted
        </Directory>
        </VirtualHost>
        ```
        - Apache再起動
          - 反映されない
          - `NameVirtualHost`を定義する必要がある  
          https://www.adminweb.jp/apache/virtual/index2.html
            - `NameVirtualHost *:443`を追記
        - Apache再起動
          - 反映されない(var/www/htmlを参照するまま)
          - `ssl.conf`でリッスンしている？  
          https://ti-tomo-knowledge.hatenablog.com/entry/2018/05/29/144435
            - コメントアウトされていたので違うと思われる(/etc/conf/httpd/conf.d/ssl.conf)
            ```
            # General setup for the virtual host, inherited from global configuration
            #DocumentRoot "/var/www/html"
            #ServerName www.example.com:443
            ```
        - 証明書発行時にドキュメントルートを上位の設定ファイルへ自動で書き込んでいる？
          - もう一度証明書発行コマンドを叩く
            - `$ certbot renew --force-renew`
            - 直らない
          - ドキュメントルート変更用っぽいコマンドがあった
            - `certbot renew --webroot-path <ドキュメントルート>`
            - これでもダメ
          - 設定ファイルがある？  
          https://stackoverflow.com/questions/37960696/change-webroot-path-of-registered-letsencrypt-cert
            - `/etc/letsencrypt/renewal/<ドメイン名>.conf`にはきちんと設定されていた。。
              - `webroot_path = <ドキュメントルート>,`
          - etc/httpd/conf配下で`var/www/html`が記述されているファイルを検索
          ```
          $ find . -type f -print | xargs grep '/var/www/html'
          ./conf.d/ssl.conf:#DocumentRoot "/var/www/html"
          ./conf/httpd-le-ssl.conf:DocumentRoot /var/www/html
          ./conf/httpd.conf.20200914:DocumentRoot "/var/www/html"
          ./conf/httpd.conf.20200914:<Directory "/var/www/html">
          ./conf/httpd.conf.202009151244:DocumentRoot /var/www/html
          ```
            - httpd-le-ssl.confが怪しい
            - 大当たりだった
              - `DocumentRoot`を書き換えて、本来のドキュメントルートへアクセスできた

### その他
#### CDNはプロトコルを指定しないようにする
https://www.webernote.net/webcreate/https-javascript.html
#### 3カ月ごとに更新する必要がある
- 有効期限が30日未満の場合
  `$ certbot renew`
- いつでも強制的に更新
  `$ certbot renew --force-renew`