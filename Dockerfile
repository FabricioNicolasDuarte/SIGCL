FROM php:8.3-apache

# 1. Instalar librerías del sistema, NodeJS y extensiones PHP
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
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
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

# 5. Copiar SOLO las dependencias primero (Magia para acelerar Docker)
COPY composer.json composer.lock ./

# 6. Instalar PHP forzando la compatibilidad
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

# 7. Copiar el resto del proyecto
COPY . .

# 8. Instalar Node y compilar los estilos de la app
RUN npm install
RUN npm run build

# 9. Permisos necesarios para que Laravel guarde PDFs y cachés
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
