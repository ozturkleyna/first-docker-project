FROM php:8.2-apache

# 1. PHP eklentilerini kuruyoruz (MySQL ile konuşması için)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 2. Composer'ı (Paket Şefi) internetten çekip PHP'nin içine yerleştiriyoruz
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Bazı kütüphaneler için gereken sistem araçlarını ekliyoruz
RUN apt-get update && apt-get install -y libzip-dev zip && docker-php-ext-install zip