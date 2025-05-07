# --- ステージ 1: ビルドステージ (builder) ---
FROM composer:2 AS builder

# 作業ディレクトリを設定
WORKDIR /app

# 依存関係定義ファイルのみ先にコピー
COPY composer.json composer.lock* ./
# composer.lock がなくてもエラーにならないようにワイルドカードを使用 (初回ビルドなど)

# 依存関係をインストール (今回は require が空なので vendor は実質空)
# 依存関係がある場合はここで vendor ディレクトリが生成される
RUN composer install --no-dev --no-interaction --optimize-autoloader

# アプリケーションコードをコピー
# public ディレクトリをコピー
COPY public ./public
# src ディレクトリなど他のコードがあれば同様にコピー
# COPY src ./src

# --- ステージ 2: 最終ステージ (runtime) ---
# 軽量なPHPイメージを使用 (CLI/ビルトインサーバー用)
FROM php:8.3-alpine AS runtime

# アプリケーション実行用の非rootユーザーを作成・設定
RUN addgroup -S appgroup && adduser -S appuser -G appgroup
RUN mkdir -p /app && chown -R appuser:appgroup /app

# 作業ディレクトリを設定
WORKDIR /app

# ビルドステージから必要なアーティファクトのみをコピー
# vendor ディレクトリ (依存関係があれば) をコピー
COPY --from=builder --chown=appuser:appgroup /app/vendor ./vendor
# アプリケーションコード (public ディレクトリ) をコピー
COPY --from=builder --chown=appuser:appgroup /app/public ./public

# 以降の命令は 'appuser' として実行
USER appuser

# アプリケーション (PHPビルトインサーバー) がリッスンするポートを指定
EXPOSE 8000

# コンテナ起動時にPHPビルトインサーバーを実行するコマンド
# -S 0.0.0.0:8000: すべてのインターフェースでポート8000をリッスン
# -t public: ドキュメントルートを public ディレクトリに設定
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]