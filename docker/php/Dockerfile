FROM php:7.4-fpm

# composerのインストール (マルチステージビルド)
COPY --from=composer:1.10 /usr/bin/composer /usr/bin/composer

# npmのインストール (マルチステージビルド)
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

#パッケージ管理ツールapt-getの更新と必要パッケージのインストール
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
&& docker-php-ext-install pdo_mysql bcmath

WORKDIR /var/www/html/laravel
