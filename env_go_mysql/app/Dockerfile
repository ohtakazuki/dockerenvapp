# 最新の安定版Goイメージを使用
FROM golang:1.24-alpine AS base

# パッケージのインストール、タイムゾーン設定
RUN apk --update --no-cache add \
    tzdata \
 && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
 && apk del tzdata

# 作業ディレクトリ設定
WORKDIR /app

# Goモジュールのキャッシュを活用
#COPY go.mod go.sum ./
#RUN go mod download

# アプリケーションコードをコピー
#COPY . .

# 開発用ツール (gopls, delve) のインストール
# delveはデバッグに必要
# goplsはVS Code Go拡張機能に必要
RUN go install golang.org/x/tools/gopls@latest \
 && go install github.com/go-delve/delve/cmd/dlv@latest

# アプリケーションが使用するポートを公開 (内部用)
EXPOSE 8080

# デバッグ用にdelveを起動可能にする (デフォルトのCMDは設定しないでおく)
# または、開発時の起動コマンドとして設定: CMD ["go", "run", "main.go"]
# 本番イメージの場合は CMD ["./your-app-binary"] のようにする