### 対象画面
- 環境構築
### 実装
- DockerfileにImageMagickおよびIMagickのインストールコマンドを記述
### 参考
https://qiita.com/saya1001kirinn/items/dacf5ef6b1d66ced846a

```dockerfile
RUN apt-get install -y \
    imagemagick \
    libmagickwand-dev

RUN pecl install imagick \
  && docker-php-ext-enable imagick
```
#### 確認
- phpinfo
- `convert --version`

#### Laravelで使うためにComposerのパッケージをセットアップする
https://qiita.com/Ago0727/items/c72daec0e2911e32888a
1. インストール
```
$ composer require intervention/image
```
2. 設定 app.php
```
'providers' => [
    .
    .
    .
    /*
     * Package Service Providers...
     */
    # 以下のコードを記述
    Intervention\Image\ImageServiceProvider::class,
]

'aliases' => [
    .
    .
    .
    'Image' => Intervention\Image\Facades\Image::class
]
```
3. ライブラリへ追加 
```
$ php artisan vendor:publish
```
- config/image.php
```
'driver' => 'imagick'
```
4. プログラムで参照
`use Intervention\Image\Facades\Image;`