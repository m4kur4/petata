### 対象画面
- バインダー
### 実装
- ファイルサイズ上限を超えた際のエラーメッセージをMB単位にする

### 参考
https://qiita.com/ryu19maki/items/f240f10eab51c792b9a4

- フォームリクエストで前処理をする
```php
    public function messages()
    {
        return [
            'file.max' => ':max_in_mb MBを超えています。',
        ];
    }

    protected function prepareForValidation()
    {
        Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':max_in_mb', $parameters[0] / 1024, $message);
        });
    }
```