# FROM php:alpine
FROM php:8.0-fpm-alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --update nodejs npm
RUN apk add --no-cache postgresql-dev

# ReactとKnockout.jsをインストール
RUN npm install -g create-react-app
RUN npm install -g knockout
RUN docker-php-ext-install pdo pdo_pgsql

# ワーキングディレクトリを設定
# WORKDIR /var/www/html
WORKDIR /var/www/fuel

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]

