# --- ステージ 1: ビルドステージ (builder) ---
# Composer公式イメージをベースに使用 (PHPバージョンは適宜合わせる)
FROM composer:2 AS builder

# 作業ディレクトリを設定
WORKDIR /app

# 依存関係定義ファイルのみ先にコピー (キャッシュ効率化のため)
COPY composer.json composer.lock* ./
# composer.lock がなくてもエラーにならないようにワイルドカードを使用

# 依存関係をインストール (今回は require が空)
RUN composer install --no-dev --no-interaction --optimize-autoloader

# --- ステージ 2: 最終ステージ (runtime) ---
# 軽量なPHP-CLIイメージを使用 (バージョンはビルドステージと合わせる)
FROM php:8.3-cli-alpine AS runtime

# アプリケーション実行用の非rootユーザーを作成・設定 (Alpine Linux)
RUN addgroup -S appgroup && adduser -S appuser -G appgroup
RUN mkdir -p /app && chown -R appuser:appgroup /app

# PostgreSQL接続に必要なPHP拡張(pdo_pgsql)とOSライブラリをインストール
# apk add --no-cache でパッケージを追加し、docker-php-ext-install で拡張を有効化
# postgresql-libs は pdo_pgsql の実行時依存関係
RUN apk add --no-cache --virtual .persistent-deps \
        postgresql-libs \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && apk del .build-deps

# 作業ディレクトリを設定
WORKDIR /app

# ビルドステージから vendor ディレクトリ (依存関係) をコピー
COPY --from=builder --chown=appuser:appgroup /app/vendor ./vendor

# アプリケーションコードをコピー
COPY --chown=appuser:appgroup src ./src

# 以降の命令は 'appuser' として実行
USER appuser

# コンテナ起動時にデフォルトで実行されるコマンドを設定
# (compose.yml の command を削除した場合にこれが使われる)
CMD ["php", "src/sample1.php"]