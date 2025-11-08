# Usar imagen oficial de PHP 8.2 con extensiones
FROM php:8.2-cli

# Instalar dependencias del sistema y extensiones PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos de dependencias primero (para cache)
COPY composer.json composer.lock ./

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev --no-interaction --ignore-platform-reqs

# Copiar package files
COPY package*.json ./

# Instalar dependencias Node
RUN npm ci --legacy-peer-deps

# Copiar el resto de la aplicación
COPY . .

# Compilar assets
RUN npm run build

# Dar permisos a storage y bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Exponer puerto
EXPOSE 8080

# Comando de inicio
CMD bash railway-deploy.sh && php artisan serve --host=0.0.0.0 --port=$PORT
