#!/usr/bin/env bash
# Salir si ocurre algún error
set -o errexit

echo "Instalando dependencias de PHP..."
composer install --optimize-autoloader --no-dev

echo "Instalando dependencias de Node (Vite/Tailwind)..."
npm install
npm run build

echo "Limpiando cachés del sistema..."
php artisan config:clear
php artisan view:clear

echo "Ejecutando migraciones de la base de datos..."
php artisan migrate --force
