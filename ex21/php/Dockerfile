# ベースイメージ: 特定バージョンの PHP CLI イメージを使用 (Alpineベースで軽量)
# CLIイメージでもXdebugやFPM連携は可能だが、用途によってはFPMイメージが良い場合もある
FROM php:8.3-cli-alpine

# 引数で作業ディレクトリを定義 (変更しやすくするため)
ARG APP_DIR=/app
WORKDIR ${APP_DIR}

# ビルド時依存関係と永続依存関係をインストール (Xdebugビルド用)
# linux-headers を .build-deps に追加
RUN apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        make \
        g++ \
        linux-headers \
    && apk add --no-cache --virtual .persistent-deps \
        tzdata

# Xdebug を PECL 経由でインストール
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug 

# Xdebug の設定ファイルを作成(既存の zend_extension 行を消さないように >> を使う)
# 念のため最初に空行を追記してから [xdebug] セクションと設定を追記
RUN echo "" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "[xdebug]" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.start_with_request=trigger" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo ";xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo ";xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=VSCODE" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# ビルド時依存関係を削除
RUN apk del .build-deps

# 非rootユーザー 'appuser' (UID 1001) を作成し、作業ディレクトリの所有者にする
# シェルを /bin/sh に指定 (-s /bin/sh を追加)
RUN addgroup -S -g 1001 appgroup && \
    adduser -S -u 1001 -s /bin/sh -G appgroup appuser && \
    mkdir -p ${APP_DIR} && \
    chown -R appuser:appgroup ${APP_DIR}

# 依存関係ファイルを先にコピー
COPY --chown=appuser:appgroup composer.json composer.lock* ./

# Composer をダウンロード・インストール
USER root
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# === composer install はここでは実行しない (devcontainer.json の postCreateCommand で実行) ===
# # 依存関係を appuser としてインストール
# USER appuser
# RUN composer install --no-interaction --optimize-autoloader

# ユーザーを appuser に戻す
USER appuser

# アプリケーションコードはこの Dockerfile ではコピーしない (マウントされるため)
# 本番用イメージなど、コードをイメージに含める場合は以下の行を追加:
# COPY --chown=appuser:appgroup public ./public
# COPY --chown=appuser:appgroup src ./src # src ディレクトリがある場合

# デフォルトのコンテナ起動コマンドは compose.yml で上書きされる想定
# (ビルトインサーバーを起動するため)
# CMD ["php", "public/index.php"] # CLI実行の場合