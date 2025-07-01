FROM php:8.2-apache
COPY config/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini /usr/local/etc/php/
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
  && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && curl -sL https://deb.nodesource.com/setup_14.x | bash - \
  && apt-get install -y nodejs npm
WORKDIR /var/www/html