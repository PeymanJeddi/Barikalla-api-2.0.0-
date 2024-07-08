FROM php:8.2-cli

RUN apt -o Acquire::Check-Valid-Until=false update && apt install -y

RUN apt install -y   libcurl4-gnutls-dev \
libxml2-dev \
libonig-dev \
libpng-dev \
libjpeg62-turbo-dev \
libfreetype6-dev \
libzip-dev \
libxslt-dev \
libicu-dev \
libssl-dev \
libreadline-dev \
git \
unzip \
wget


RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath opcache xml curl gd dom

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

CMD ["php", "artisan", "serve"]
