FROM node:20.3-alpine

# パッケージのインストール、タイムゾーン設定
RUN apk --update --no-cache add \
    tzdata \
 && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
 && apk del tzdata
