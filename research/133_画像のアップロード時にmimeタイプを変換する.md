### 対象画面
- バインダー
### 実装
- Async Clipboard APIがpngにしか対応していないので、アップロード時にファイル形式を変換する
### 参考
http://ithat.me/2016/12/13/php-image-format-jpg-png-gif-convert-to  
```php
// 変換前ファイル読み込み（ファイル形式によって関数を使い分ける）
$image = @imagecreatefrompng('input.png');
$image = @imagecreatefromjpeg('input.jpg');
$image = @imagecreatefromgif('input.gif');

// 指定形式に変換
imagepng($image, 'output.png');
imagejpeg($image, 'output.jpg');
imagegif($image, 'output.gif');

// メモリの解放
imagedestroy($image);
```