# 1. Usar una imagen oficial de PHP con un servidor Apache integrado
FROM php:8.2-apache

# 2. Instalar dependencias del sistema y extensiones PHP que necesita Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    libpq-dev \
    libonig-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring gd

# 3. Habilitar las URLs amigables de Apache (mod_rewrite)
RUN a2enmod rewrite

# 4. Cambiar la carpeta principal de Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Copiar todo el código de tu proyecto al contenedor
COPY . /var/www/html

# 6. Instalar Composer para las librerías de PHP
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# 7. Instalar Tailwind/Vite y compilar los estilos neón
RUN npm install
RUN npm run build

# 8. Darle permisos al servidor para guardar PDFs y cachés
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
