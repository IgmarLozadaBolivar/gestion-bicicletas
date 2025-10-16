FROM php:8.2-fpm as builder

RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Producción
FROM php:8.2-fpm

# Instalar Nginx
RUN apt-get update && apt-get install -y nginx libzip-dev libpq-dev unzip \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY --from=builder /var/www /var/www

# Copiar nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Habilitar config
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Crear directorios necesarios
RUN mkdir -p /run/php \
    && mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R 755 storage bootstrap/cache

# Exponer puerto HTTP
EXPOSE 80

# Iniciar Nginx + PHP-FPM juntos
CMD service php-fpm start && nginx -g 'daemon off;'
