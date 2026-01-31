#!/bin/bash

# Script de despliegue para Grajalsin
# Dominio: grajalsin.com.mx
# IP: 84.32.84.32
# Puerto: 50

set -e

echo "🚀 Iniciando despliegue de Grajalsin..."

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Directorio del proyecto
PROJECT_DIR="/var/www/grajalsin/Grajalsin"
cd "$PROJECT_DIR"

echo -e "${GREEN}📦 Instalando dependencias de Composer...${NC}"
composer install --no-dev --optimize-autoloader

echo -e "${GREEN}📦 Instalando dependencias de NPM...${NC}"
cd "$PROJECT_DIR"
npm ci --production=false

echo -e "${GREEN}🔨 Compilando assets con Vite...${NC}"
npm run build

echo -e "${GREEN}🔑 Verificando archivo .env...${NC}"
if [ ! -f .env ]; then
    echo -e "${YELLOW}⚠️  Archivo .env no encontrado. Por favor, créalo manualmente.${NC}"
    exit 1
fi

echo -e "${GREEN}🗄️  Ejecutando migraciones...${NC}"
php artisan migrate --force

echo -e "${GREEN}🔐 Estableciendo permisos...${NC}"
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo -e "${GREEN}🔧 Optimizando Laravel para producción...${NC}"
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan event:cache

echo -e "${GREEN}🔐 Verificando permisos finales...${NC}"
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

echo -e "${GREEN}✅ Despliegue completado exitosamente!${NC}"
echo -e "${YELLOW}📝 Recuerda reiniciar PHP-FPM y Nginx:${NC}"
echo -e "   sudo systemctl restart php8.2-fpm"
echo -e "   sudo systemctl restart nginx"

