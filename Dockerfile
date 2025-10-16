# Etapa de construcción
FROM php:8.2-fpm as builder

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos del proyecto
COPY . .

# Instalar dependencias de PHP sin las de desarrollo
RUN composer install --no-dev --optimize-autoloader

# Etapa de producción
FROM php:8.2-fpm

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Establecer directorio de trabajo
WORKDIR /app

# Copiar configuración PHP personalizada si tienes
# (Opcional - elimina esta línea si no tienes custom php.ini)
# COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Copiar archivos del builder
COPY --from=builder /app /app

# Crear directorios necesarios
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data /app \
    && chmod -R 755 storage bootstrap/cache

# Cambiar a usuario sin privilegios
USER www-data

# Exponer el puerto (opcional, Render usa el que necesite)
EXPOSE 8000

# Comando por defecto para ejecutar php-fpm
CMD ["php-fpm"]
