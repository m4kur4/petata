# PETATA!

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/makura016/petata.svg?style=flat-square)](https://scrutinizer-ci.com/g/makura016/petata)
[![Build Status](https://scrutinizer-ci.com/g/makura016/petata/badges/build.png?b=master)](https://scrutinizer-ci.com/g/makura016/petata/build-status/master)
[![shields.io](https://img.shields.io/github/issues/makura016/petata)](https://github.com/makura016/petata/issues)

[![Image from Gyazo](https://i.gyazo.com/a13a97d1223044098ad574bc147c7413.png)](https://gyazo.com/a13a97d1223044098ad574bc147c7413)

イラスト制作やWebデザイン等の資料となる画像ファイルを管理するSPAです。  

## 目次
- [動作環境](#動作環境)
- [開発目的](#開発目的)
- [用途](#用途)
- [機能概要](#機能概要)
- [使い方](#使い方)
- [更新履歴](#更新履歴)

## 動作環境
Google Chrome 85のみ動作確認をしています。  
同ブラウザのある程度新しいバージョンであれば動作すると思われます。  
それ以外のブラウザは動作対象外です。

## 開発目的

- 自身及び周囲のクリエイターの創作活動を効率化すること。
- サーバサイド開発の知識を取りまとめること。
- フロントエンド開発の知見を得ること。
- Webアプリケーションのリリース方法を学ぶこと。

## 用途

- ローカルに保存している画像をクラウド上で管理することにより、ディスク容量の圧迫を解消する。
- 必要な画像をすぐに見つけられるようにする。
- 画像の整理を効率化する。
- 作品同士の比較分析を簡単にできるようにする。
  - サムネイルを自由な配置に並べる
  - 拡大画像を連続して切り替える
  - ペイントソフトにワンアクションで読み込ませる

## 機能概要
複数の画像を**バインダー**という単位に取りまとめて管理します。  
**バインダー**に保存している画像には**ラベル**を設定することができます。  

**ラベル**はユーザーが任意に作成できる画像の分類です。  
**バインダー**ごとに**ラベル**を登録することで、必要な画像の絞り込みを簡単に行うことができます。  
一枚の画像に対して複数の**ラベル**を設定することもできます。

![overview](https://user-images.githubusercontent.com/50965145/93464107-9bb93800-f923-11ea-9159-6b1c8ac8c9f5.png)

## 使い方
### 1. バインダーを作成する
バインダーの名前と説明を入力します。  
バインダー作成時点で、右カラムからラベルを登録することもできます。

[![Image from Gyazo](https://i.gyazo.com/47975355ce84a18c7aa69b3f9c5a893a.gif)](https://gyazo.com/47975355ce84a18c7aa69b3f9c5a893a)
---
### 2. バインダーを開き、画像をアップロードする
(1)で作成したバインダーが一覧に表示されるため、ダブルクリックで開きます。  
中央のエリアに画像をドラッグ&ドロップすることで、ファイルがアップロードされます。  
複数ファイルを同時にアップロードすることも可能です。

[![Image from Gyazo](https://i.gyazo.com/fdc55ff2961323ca637edc61b59c6116.gif)](https://gyazo.com/fdc55ff2961323ca637edc61b59c6116)
---
### 3. 画像とラベルを紐づける
画像とラベルの関連付けを**ラベリング**と呼びます。  
(2)でアップロードした画像を右カラムに表示されているラベルへドラッグ&ドロップすることで、  
「**ラベリング**の登録」「**ラベリング**の解除」をすることができます。

[![Image from Gyazo](https://i.gyazo.com/07d4dabf4ef50f1df2dc31d74ec17d34.gif)](https://gyazo.com/07d4dabf4ef50f1df2dc31d74ec17d34)
  

複数の画像とラベルを同時にラベリングすることもできます。

[![Image from Gyazo](https://i.gyazo.com/37144cd6bff0b30996a0107ebf9829b2.gif)](https://gyazo.com/37144cd6bff0b30996a0107ebf9829b2)

---
### 4. 画像・ラベルの並び順を変更する
画像とラベルはドラッグ&ドロップによって並び順を変更することができます。  
(画像は通常のドラッグを**ラベリング**に使用するため、左上のハンドルによって並び替えます。)  
変更した並び順は保存されます。  

[![Image from Gyazo](https://i.gyazo.com/198205e79409327773d4166053a1ce1a.gif)](https://gyazo.com/198205e79409327773d4166053a1ce1a)

---
### 5. その他の機能
アップロードした画像に対して以下のような操作が可能です。
- ファイル名検索
- リネーム
- クリップボードへコピー
- ライトボックス表示  
- 表示中の画像を一括ダウンロード

[![Image from Gyazo](https://i.gyazo.com/b4ab550b6b71d9ec6de3ca0ce80462b2.gif)](https://gyazo.com/b4ab550b6b71d9ec6de3ca0ce80462b2)

---
## 変更履歴
| 更新日 | 内容  |
| --- | --- |
| 2020.09.17 | 新規作成 |
