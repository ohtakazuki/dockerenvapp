FROM php:8.2-apache

# tzdataのインストール
RUN apt-get update -qq \
 && apt-get install -y --no-install-recommends \
    tzdata \
 && rm -rf /var/lib/apt/lists/*

# タイムゾーンを設定する環境変数
ENV TZ="Asia/Tokyo"

# 作業ディレクトリを変更
WORKDIR /usr/local/etc/php

# ファイルのコピー
COPY php.ini ${PWD}

# 一時変数の定義
ARG wdir

# 作業ディレクトリを変更
WORKDIR $wdir
