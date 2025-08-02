# 旅のしおりブックマークアプリ

## ①課題名
PHP×MySQLで作る備忘録ブックマークアプリ

## ②課題内容（どんな作品か）
ユーザー登録・ログイン後、自分専用のブックマーク（備忘録）を登録・編集・削除できるシンプルなWebアプリ

## ③アプリのデプロイURL
https://gsacademy.sakura.ne.jp/bookmark/login.php

## ④アプリのログイン用IDまたはPassword（ある場合）
- ID: TEST
- PW: test

## ⑤工夫した点・こだわった点
- PHP＋MySQLで基本的なCRUD（登録・表示・編集・削除）を実装

## ⑥難しかった点・次回トライしたいこと（又は機能）
- データベース連携・エラー対応
- 次回は画像アップロードやタグ機能、スマホ対応デザインも追加したい

## ⑦フリー項目（感想、シェアしたいこと等なんでも）
- PHPとMySQLの連携を通じてWebアプリの仕組みを理解できました。

## 構成ファイル
- login.php: ログイン画面・処理
- register.php: ユーザー登録画面・処理
- bookmark_list.php: ブックマーク一覧表示
- bookmark_add.php: ブックマーク追加
- bookmark_delete.php: ブックマーク削除
- bookmark_update.php: ブックマーク更新
- db_connect.php: DB接続
- db_schema.sql: テーブル作成用SQL
