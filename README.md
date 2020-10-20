# AsaKotsu

**朝活に特化したSNSアプリです。**

コンセプトは、以下の２点です。

```

①仲間を作り、"コツコツ"朝活を継続するモチベーションを高める

②朝活を成功させるための「コツ」をみんなで共有して学ぶ

```

基本的なSNS機能に加えて、グループでZoomミーティングによる朝活を開始する機能や、
朝活のコツを共有する機能、早起き継続日数のランキング機能などがあります。（※未完成）

※朝活のコツの共有・・・例）光目覚まし時計や安眠グッズのような商品情報や、早寝早起きのコツを紹介するYoutubeや書籍のシェア、その他気付いたことの発信など

## 機能一覧

* ユーザー関連
  * 新規登録、ログイン、ログアウト機能
* 投稿関連(CRUD)
  * 新規投稿、投稿一覧表示、編集、削除機能
* コメント機能
  * ユーザー投稿に対してコメントを投稿
* タグ機能
  * タグ別に、投稿を一覧表示
* いいね機能
  * いいねした投稿の一覧表示
* フォロー機能
  * フォローしているユーザー、フォロワーの一覧表示
* 外部API連携
  * ZoomAPI(CRUD)
    * ミーティングの新規作成、ミーティング一覧表示、ミーティング編集、ミーティングの削除機能
* 画像アップロード機能
  * ユーザープロフィール画像


## 使用技術

* フロントエンド
  * Vue.js 2.6.11
  * Blade(Laravel)
  * MDBootstrap

* バックエンド
  * PHP 7.4.9
  * Laravel 6.18.36

* インフラ
  * Docker 19.03.12
  * docker-compose 1.26.2
  * nginx 1.18
  * mysql 5.7.31

* その他使用ツール
  * VisualStudioCode
  * Postman
  * Adobe XD


## ER図
![AsaKotsu_ERD](https://user-images.githubusercontent.com/58071320/96544796-34a3f000-12e2-11eb-9dd6-c6a9f8ad9c9c.png)
