# AsaKotsu

**朝活に特化したSNSアプリです。**
<br><br>
**URL：** https://pf.asakotsu.com/

コンセプトは、以下の２点です。

```

①仲間を作り、"コツコツ"朝活を継続するモチベーションを高める

②朝活を成功させるための「コツ」をみんなで共有して学ぶ

```

ユーザー投稿、いいね、フォローといった基本的なSNS機能に加えて、グループで朝活Zoomミーティングを作成する機能や、
朝活のコツ(「朝コツ」)を共有する機能、1月毎の早起き達成日数のランキング機能などがあります。

※朝活のコツの共有・・・例）光目覚まし時計や安眠グッズのような商品情報や、早寝早起きのコツを紹介するYoutubeや書籍のシェア、その他気付いたことの発信など

## 使用技術

* フロントエンド
  * Vue.js 2.6.11
  * jQuery 3.4.1
  * Blade(Laravel)
  * MDBootstrap

* バックエンド
  * PHP 7.4.9
  * Laravel 6.18.36
  * PHPUnit 8.5.8

* インフラ
  * CircleCi
  * Docker 19.03.12
  * docker-compose 1.26.2
  * nginx 1.18
  * mysql 5.7.31
  * AWS ( EC2, ALB, ACM, S3, RDS, CodeDeploy, SNS, Chatbot, CloudFormation, Route53, VPC, EIP, IAM )

* その他使用ツール
  * Visual Studio Code
  * Postman
  * draw.io
  * Adobe XD

## AWS構成図

![AWS Diagram](https://user-images.githubusercontent.com/58071320/98456202-079a7d00-21be-11eb-8902-8bbaea816cf3.png)

## 機能一覧

* ユーザー登録関連
  * 新規登録、プロフィール編集機能
  * ログイン、ログアウト機能
  * かんたんログイン機能（ゲストユーザーログイン）

* ZoomAPI連携
    * 朝活Zoomミーティング機能(CRUD)
      * ミーティングの新規作成、一覧表示、編集、削除機能

* 早起き達成の判定機能
  * ユーザー毎に目標起床時刻を設定可能（4:00〜10:00まで）
  * 目標起床時間より前に投稿をすることができれば、早起き達成記録が１日分増えます。<br>
    例）目標起床時間を7:00とした場合、4:00〜7:00に起床できれば早起き達成<br>
    ※3時間前の時間帯までが対象

* ユーザーの早起き達成日数のランキング機能（1ヶ月毎）

* 無限スクロール機能(jQuery / inview.js / ajax)

* ユーザー投稿関連(CRUD)

* コメント機能

* タグ機能(Vue.js / Vue Tags Input)

* いいね機能(Vue.js / ajax)

* フォロー機能

* フラッシュメッセージ表示機能(jQuery/ Toastr)
  * 投稿、編集、削除、ログイン、ログアウト時にフラッシュメッセージを表示

* 画像アップロード機能(AWS S3バケット)


## ER図
![AsaKotsu_ERD](https://user-images.githubusercontent.com/58071320/96544796-34a3f000-12e2-11eb-9dd6-c6a9f8ad9c9c.png)
