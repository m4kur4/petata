### Log::debugでobject型を出力
```
Log::debug((array)$response);
```

### Laravelでサポートしている拡張phpunit
https://readouble.com/laravel/6.x/ja/http-tests.html

- laravel-mixのコンパイル設定はwebpack.mix.jsで以下のように記述されている。  
コンパイル先の指定はここで行う。
```
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
```
