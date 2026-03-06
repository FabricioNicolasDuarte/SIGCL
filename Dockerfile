FROM php:8.3-apache

# 1. Instalar dependencias del sistema y NodeJS
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

# 5. Copiar TODO el código del proyecto al contenedor
COPY . .

# 6. Instalar dependencias de PHP (Bloqueando los scripts automáticos que causan el error)
RUN composer install --optimize-autoloader --no-dev --no-scripts --ignore-platform-reqs

## 7. Instalar Node y compilar los estilos
RUN npm install
RUN npm run build

# 8. Crear el archivo de base de datos en blanco y ejecutar migraciones
RUN touch /var/www/html/database/database.sqlite
RUN php artisan migrate --force

# 9. Dar permisos absolutos para que el servidor pueda escribir en la base de datos y generar PDFs
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
