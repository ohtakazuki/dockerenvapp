FROM golang:1.20-alpine

# パッケージのインストール、タイムゾーン設定
RUN apk --update --no-cache add \
    tzdata \
 && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
 && apk del tzdata

# デバッグ用ツールのインストール
RUN go install -v github.com/ramya-rao-a/go-outline@latest \
 && go install -v golang.org/x/tools/gopls@latest \
 && go install -v github.com/go-delve/delve/cmd/dlv@latest
