FROM ubuntu:23.04

# Nginxのインストール
RUN apt-get update -qq \
 && apt-get install -y --no-install-recommends \
    nginx tzdata \
 && rm -rf /var/lib/apt/lists/*

# タイムゾーンを設定する環境変数
ENV TZ="Asia/Tokyo"

# ポートの指定
EXPOSE 80

# ファイルのコピー
COPY src/index.html /var/www/html/

# Nginxの起動
CMD ["nginx", "-g", "daemon off;"]