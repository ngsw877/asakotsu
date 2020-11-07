# AsaKotsu

**朝活に特化したSNSアプリです。**

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
  * AWS
    * EC2　：　Laravel, PHP, Nginx
    * EIP / Route53　：　固定IPアドレス、ドメイン
    * VPC
    * ELB(ALB)
    + ACM ：　SSL証明書を発行
    * RDS　；　MySQL
    * S3　：　画像データ、ビルド後のコードを保存
    * CodeDeploy　：　CircleCIと連動してCI/CDパイプラインを構築
    * SNS / Chatbot　：　CodeDeployの開始と終了をSlackに通知
    * IAM
    * CloudFormation　：　AWSインフラテンプレート

* その他使用ツール
  * VisualStudioCode
  * Postman
  * Adobe XD

## AWS構成図

![AWS Diagram](https://user-images.githubusercontent.com/58071320/98453077-8e3c6380-2198-11eb-81f9-836cf418469b.png)

## 機能一覧

* ユーザー関連
  * 新規登録、プロフィール編集機能
  * ログイン、ログアウト機能
  * かんたんログイン機能（ゲストユーザーログイン）

* 外部API連携
  * ZoomAPI
    * 朝活Zoomミーティング関連機能(CRUD)
      * 新規作成、ミーティング一覧表示、ミーティング編集、ミーティングの削除機能

* 早起き達成の判定機能
  * ユーザー毎に目標起床時間を設定して、その時間から3時間前までの時間帯に投稿をすることができれば、早起き達成記録が１日分増えます。
    例）目標起床時間を7:00とした場合、4:00〜7:00に起床できれば早起き達成

* 早起き達成日数のランキング機能（1ヶ月毎）
  * １ヶ月毎の、ユーザーの早起き達成日数を集計し、早起き達成日数が多い順にユーザーを表示

* 無限スクロール機能(jQuery / inview.js / ajax)

* ユーザー投稿関連(CRUD)
  * 新規投稿、投稿一覧表示、編集、削除機能
  
* コメント機能
  * ユーザー投稿に対してコメントを投稿
  
* タグ機能(Vue.js / Vue Tags Input)
  * タグ別に、投稿を一覧表示（投稿をカテゴリー化）
  
* いいね機能(Vue.js / ajax)
  * いいねした投稿の一覧表示
  
* フォロー機能
  * フォローしているユーザー、フォロワーの一覧表示

※ フラッシュメッセージ表示機能(jQuery/ Toastr)
  * 投稿、編集、削除、ログイン、ログアウト時にフラッシュメッセージを表示
    
* 画像アップロード機能
  * ユーザープロフィール画像等をAWS S3バケットにアップロード/読み込み

## ER図
![AsaKotsu_ERD](https://user-images.githubusercontent.com/58071320/96544796-34a3f000-12e2-11eb-9dd6-c6a9f8ad9c9c.png)
