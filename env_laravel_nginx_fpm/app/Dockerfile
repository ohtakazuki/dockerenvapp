# 軽量PHP-FPMイメージ
FROM php:8.3-fpm-alpine as runtime

# Composer 実行ファイルをコピー
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup -S -g 1000 appgroup && \
    adduser -S -u 1000 -G appgroup -s /bin/sh appuser

RUN apk update && \
    apk add --no-cache \
      tzdata \
      icu-libs \
      libzip \
      oniguruma \
      git \
      && \
    apk add --no-cache --virtual .build-deps \
      $PHPIZE_DEPS \
      linux-headers \
      icu-dev \
      libzip-dev \
      oniguruma-dev \
      && \
    pecl install xdebug && \
    docker-php-ext-configure zip && \
    docker-php-ext-install -j$(nproc) \
      pdo_mysql \
      intl \
      zip \
      mbstring \
      && \
    docker-php-ext-enable xdebug && \
    apk del .build-deps && \
    rm -rf /var/cache/apk/*

# PHP設定ファイルをコピー (Dockerfileと同じディレクトリから)
COPY php.ini /usr/local/etc/php/conf.d/custom-php.ini

WORKDIR /var/www/html

ENV TZ="Asia/Tokyo"
USER appuser

# PHP-FPM をフォアグラウンドで起動 (ベースイメージに含まれている場合が多いが明示)
CMD ["php-fpm"]