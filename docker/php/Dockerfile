FROM php:8.4-fpm

# Instaliraj sistemske zavisnosti
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instaliraj PHP ekstenzije
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    xml

# Instaliraj Redis PHP ekstenziju
RUN pecl install redis && docker-php-ext-enable redis

# Instaliraj Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Postavi radni direktorij
WORKDIR /var/www

# Kopiraj fajlove aplikacije
COPY . .

# Napravi direktorije i postavi dozvole PRIJE composer install
RUN mkdir -p /var/www/bootstrap/cache \
    && mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/storage/framework/cache \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Instaliraj PHP zavisnosti
RUN composer install --optimize-autoloader --no-dev

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
