FROM php:8.3-apache

# 1. Instalar dependencias del sistema (Sin Node.js)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    libpq-dev \
    libonig-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring gd zip bcmath pcntl

# 2. Habilitar URLs amigables de Apache
RUN a2enmod rewrite

# 3. Configurar la carpeta public de Laravel como raíz
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 4. Traer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 5. Copiar TODO el código del proyecto al contenedor (Aquí viajan los estilos ya compilados)
COPY . .

# 6. Instalar dependencias de PHP
RUN composer install --optimize-autoloader --no-dev --no-scripts --ignore-platform-reqs

# 7. Dar permisos absolutos (y crear la carpeta si no existe para evitar crash)
RUN mkdir -p /var/www/html/public/build
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/build
