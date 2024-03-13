FROM php:alpine

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --update nodejs npm

# ReactとKnockout.jsをインストール
RUN npm install -g create-react-app
RUN npm install -g knockout

# ワーキングディレクトリを設定
# WORKDIR /var/www/html
WORKDIR /var/www/fuel

CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]

