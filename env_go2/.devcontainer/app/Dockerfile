FROM golang:1.15-buster

# タイムゾーンの設定、パッケージのインストール
RUN apt-get update && apt-get install -y \
    tzdata \
 && rm -rf /var/lib/apt/lists/* \
 && go get -u github.com/gin-gonic/gin \
 && go get -u gorm.io/gorm \
 && go get -u gorm.io/driver/mysql \
 && go get -u github.com/derekparker/delve/cmd/dlv

# タイムゾーンを設定する環境変数
ENV TZ=Asia/Tokyo
