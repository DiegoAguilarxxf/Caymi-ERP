FROM php:8.4-cli

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev \
    nodejs npm

# Extensiones PHP
RUN docker-php-ext-install pdo pdo_pgsql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Instalar Node + build assets
RUN npm install
RUN npm run build

# 🔥 IMPORTANTE: optimizar Laravel para producción
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Permisos
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=$PORT