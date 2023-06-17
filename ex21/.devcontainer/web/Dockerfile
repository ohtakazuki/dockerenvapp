FROM php:8.2-apache

# tzdata、xdebugのインストール
RUN apt-get update -qq \
 && apt-get install -y --no-install-recommends \
    tzdata \
 && pecl install xdebug \
 && rm -rf /var/lib/apt/lists/*

# タイムゾーンを設定する環境変数
ENV TZ="Asia/Tokyo"

