FROM php:8.2-apache

# tzdataのインストール
RUN apt-get update -qq \
 && apt-get install -y --no-install-recommends \
    tzdata \
    libpq-dev \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-install pdo_pgsql

# タイムゾーンを設定する環境変数
ENV TZ="Asia/Tokyo"
