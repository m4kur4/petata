# API

## 認証/認可
| 内容 | 凡例 |
| ---- | :----: |
| 認証不要 | - |
| 要：ログイン | 1 |
| 要：バインダー閲覧権限 | 2 |
| 要：バインダー管理者 | 3 |

## 一覧
| URL | メソッド | 認証 | 内容 |
| ---- | ---- | :----: | ---- |
| /api/user/register |  POST | - | ユーザー登録 |
| /api/user/unregister |  POST | 1 | ユーザー登録解除 |
| /api/auth/login | POST | - | ログイン |
| /api/auth/logout | POST | 1 | ログアウト |
| /api/binder/create | POST | 1 | バインダー作成 |
| /api/binder/list | GET | 1 | 閲覧可能なバインダー一覧の取得 |
| /api/binder/authorize | POST | 3 | バインダー閲覧権限の付与 |
| /api/binder/unauthorize | POST | 3 | バインダー閲覧権限の剥奪 |
| /api/binder/favorite | POST | 2 | バインダーのお気に入り設定 |
| /api/binder/image/add | POST | 2 | バインダーへ画像追加 |
| /api/binder/image/delete | POST | 2 | バインダーから画像削除 |
| /api/binder/image/search | GET | 2 | バインダーで管理している画像一覧の取得 |
| /api/binder/image/detail | GET | 2 | 画像情報取得 |
| /api/binder/image/sort | POST | 2 | 画像並び順更新 |
| /api/binder/label/save | POST | 2 | バインダーへラベル追加(更新) |
| /api/binder/label/delete | POST | 2 | バインダーからラベル削除 |
| /api/binder/label/register | POST | 2 | ラベリング登録 |
| /api/binder/label/unregister | POST | 2 | ラベリング登録解除 |
| /api/binder/label/sort | POST | 2 | ラベル並び順更新 |
