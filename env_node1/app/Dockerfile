FROM node:22-alpine

# タイムゾーン設定
RUN apk --update --no-cache add \
    tzdata \
 && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
 && apk del tzdata

# 作業ディレクトリ設定
WORKDIR /var/www/html

# 非rootユーザーで実行
USER node

# アプリケーションが使用するポートを公開
EXPOSE 3000