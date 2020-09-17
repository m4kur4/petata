### 参考
https://agohack.com/zipstream-php-aws-s3-download/  
- ZipStream-PHPを使う
```
PHP の ZIP ストリーミングライブラリ。
maennchen/ZipStream-PHP

バージョン 1.0.0 以上は PHP 7.1 以降が必須。
バージョン 0.5.2 は PHP 7.0 以降が必須。
```
- larabel向けのパッケージがあった(内部でZipStream-PHPを使っている)  
https://qiita.com/rio1228/items/c60594344a6304608c3f  
https://github.com/stechstudio/laravel-zipstream  

### 作業
- パッケージをインストールする  
`composer require stechstudio/laravel-zipstream`  
`Zip`ファサードのエイリアスは自動設定される模様(見たところapp.php等が書き換わっていない?どこで設定しているのか)  

#### 実装
##### サーバー
```php
    public function execute(Request $request)
    {
        $images = Image::query()
            ->whereIn('id', $request->image_ids)
            ->get();
            
        $FILE_NAME = 'binder.zip';
        $zip = Zip::create($FILE_NAME);

        foreach($images as $image) {
            $file_path = FileManageHelper::getBinderImageS3Path($image);
            $file_name = $image->name . '.' . $image->extension;
            $zip->add($file_path, $file_name);
        }

        return $zip;
    }
```
- `FilenameMissingException`と出た
  - ファイルがない場合のエラー  
  https://github.com/stechstudio/laravel-zipstream/issues/6  

- 将来的にファイル名を反映する場合、リネーム処理でオリジナル画像の名前を設定する処理を組み込む  
https://pgmemo.tokyo/data/archives/1759.html
  - 現状は不要なので未実装

##### フロント
```js
    async downloadImages(context) {
        // 表示中の画像ID
        const imageIds = state.images.map(image => image.id);
        const request = {
            image_ids: imageIds
        };

        const uri = `api/binder/image/download`;
        const response = await axios
            .get(`${uri}`, { params: request })
            .catch(err => err.response || err);

        // 200でダウンロードできていることを確認
        // →どうやってブラウザで開く？
    },
```
### レスポンスが返ってきて、どのように保存ダイアログを開くか
https://qiita.com/koushisa/items/ac908d81361534264d35
- File API
- または`file-server`というライブラリ
`npm install --save file-saver`
`import { saveAs } from 'file-saver';`
  - `saveAs()`はURLからfetchする処理でブラウザ間の差異を吸収するもので、HTTPレスポンスを処理するわけではなかった。
  ```
  app.js:48172 DOMException: Failed to execute 'open' on 'XMLHttpRequest': Invalid URL
    at d (http://localhost:8888/js/app.js:6617:677)
    at a (http://localhost:8888/js/app.js:6617:1411)
    at _callee14$ (http://localhost:8888/js/app.js:67463:74)
    at tryCatch (http://localhost:8888/js/app.js:26683:40)
    at Generator.invoke [as _invoke] (http://localhost:8888/js/app.js:26913:22)
    at Generator.next (http://localhost:8888/js/app.js:26738:21)
    at asyncGeneratorStep (http://localhost:8888/js/app.js:66399:103)
    at _next (http://localhost:8888/js/app.js:66401:194)
  ```
- 使い方が違う
  - Blobオブジェクトとしてダウンロードして、URLオブジェクトを作るらしい(下記コードはaxiosやfileSaverを使わない例)  
  https://www.atmarkit.co.jp/ait/articles/1603/30/news026.html
  ```js
  function downloadFile(url, filename) {
  "use strict";

  // XMLHttpRequestオブジェクトを作成する
  var xhr = new XMLHttpRequest();
  xhr.open("GET", url, true);
  xhr.responseType = "blob"; // Blobオブジェクトとしてダウンロードする
  xhr.onload = function (oEvent) {
      // ダウンロード完了後の処理を定義する
      var blob = xhr.response;
      if (window.navigator.msSaveBlob) {
      // IEとEdge
      window.navigator.msSaveBlob(blob, filename);
      }
      else {
      // それ以外のブラウザ
      // Blobオブジェクトを指すURLオブジェクトを作る
      var objectURL = window.URL.createObjectURL(blob);
      // リンク（<a>要素）を生成し、JavaScriptからクリックする
      var link = document.createElement("a");
      document.body.appendChild(link);
      link.href = objectURL;
      link.download = filename;
      link.click();
      document.body.removeChild(link);
      }
  };
  // XMLHttpRequestオブジェクトの通信を開始する
  xhr.send();
  }
  ```
- 最終的な実装
  - content-dispositionからファイル名を取得する  
  https://developer.mozilla.org/ja/docs/Web/HTTP/Headers/Content-Disposition
  - 以下のフォーマットで入ってくる  
  `attachment; filename*=UTF-8''binder.zip`
```js
        if (response.status === STATUS.OK) {
            const blob = new Blob([response.data], {
                type: response.data.type
            });

            const fileName = util.getFileName(response);
            saveAs(blob, fileName);
        }
```
```js
    getFileName(response) {
        const contentDisposition = response.headers["content-disposition"];
        let fileName = contentDisposition
            .split("'")
            .slice(-1)[0];
        
        fileName = decodeURI(fileName)
        return fileName;
    },
```
### ダウンロードは出来るがファイルが壊れており解凍できない
- サーバーで壊れているのか、Blobにするところで壊れているのか
- 同じような事象の記事  
https://qiita.com/na9amura/items/dd639d774ffcd5c7178f

- ここがマズい模様
```js
            const blob = new Blob([response.data], {
                type: response.data.type
            });
```

- 以下で解決
```js
        const response = await axios
            .get(`${uri}`, {
                params: request,
                responseType: "blob",
                headers: { Accept: "application/zip" }
            })
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);

            const fileName = util.getFileName(response);
            saveAs(response.data, fileName);
        }
```
### 上記のコードは何をしているのか？
`ArrayBufferを指定して、明示的にバイナリデータを受信するように設定`と書いてある方法
- ここ
```js
    responseType: "blob",
    headers: { Accept: "application/zip" }
```
- HTTPリクエストに「このファイルをください」と明示させ、ブラウザ側に「データの形式」を保証させる?
  - zipか何なのかわからないファイルを単純に`new Blob`とすることはできないということ?
### トラブルシュートの方法
- 上記参考記事を書いた人
  - 拡張子をtxtに変えて壊れたzipを確認している?
  - 壊れたもの/正常なものをtxtに変えて比較してみた⇒特に違いが分からなかった(中身は違うが文字化けしている)。
  - TODO: zipファイルの仕組みを調べる
