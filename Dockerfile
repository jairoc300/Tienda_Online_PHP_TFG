FROM php:8.4-cli-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8080

CMD ["php", "-d", "upload_max_filesize=20M", "-d", "post_max_size=20M", "-d", "file_uploads=On", "-S", "0.0.0.0:8080", "-t", "public", "router.php"]
