
### 参考
https://qiita.com/pomcho555/items/b9dcae3a5afeafd1f14f

### Dropzone.jsの利用方法
https://www.dropzonejs.com/#usage

#### アップロード前後等の制御
https://pgmemo.tokyo/data/archives/982.html

#### 詰まった
- 第二引数の必須オプションが指定されていない
```
Error: No URL provided.
```
- POST時にCSRFチェックで弾かれる  
    - headersオプションにトークンを仕込む
    - 参考：https://stackoverrun.com/ja/q/13108311  
    https://stackoverflow.com/questions/30149023/how-to-include-the-csrf-token-in-the-headers-in-dropzone-upload-request  

    こんな感じで実装すればOKだった
    ```
    const fileUploader = {};
    fileUploader.dropzoneConfiguer = {
        url: '/file/post',
        paramName: 'image_dropzone', // name
        maxFilesize: 2, //MB
        clickable: false,
    };
    // Bladeでトークンを生成して受け渡す()
    fileUploader.init = (csrfToken) => {
        // 419
        fileUploader.dropzoneConfiguer.headers = {
            'X-CSRF-TOKEN': csrfToken
        };
    };
    fileUploader.createDropzone = (selector) => {
        const myDropzone = new Dropzone(selector, fileUploader.dropzoneConfiguer);
        return myDropzone;
    }
    ```
- ↑または、sendingというイベントがあるのでそこで埋め込む（その方が自然か）
- paramNameがname属性と扱われてPOSTされる
- urlはBladeから受け渡すべき
- アップロード時にサムネが生成されるのを防止する  
⇒https://stackoverflow.com/questions/33842555/remove-previews-from-dropzone-after-success  
(処理成功時に発火するメソッドでHTMLを削除する)  
⇒削除までの間に一瞬ファイル情報が表示されてしまうので、cssで".dz-preview"を見えなくした。


