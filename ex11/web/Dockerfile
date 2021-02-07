FROM php:7.4-apache

# tzdataのインストール
RUN apt-get update && apt-get install -y \
    tzdata \
    libpq-dev \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-install pdo_pgsql

# タイムゾーンを設定する環境変数
ENV TZ=Asia/Tokyo
