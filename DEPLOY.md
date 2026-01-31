# Guía de Despliegue - Grajalsin

## Información del Servidor
- **IP**: 84.32.84.32
- **Puerto**: 50 (si es necesario para configuración específica)
- **Dominio**: grajalsin.com.mx
- **Ruta del proyecto**: `/var/www/grajalsin/Grajalsin`

## Requisitos Previos

1. **PHP 8.2+** con extensiones:
   - php8.2-fpm
   - php8.2-mysql (o php8.2-pgsql según tu BD)
   - php8.2-mbstring
   - php8.2-xml
   - php8.2-curl
   - php8.2-zip
   - php8.2-gd

2. **Composer** instalado globalmente

3. **Node.js y NPM** (versión 18+ recomendada)

4. **Nginx** configurado y funcionando

5. **Base de datos** configurada (MySQL, PostgreSQL, etc.)

## Pasos de Despliegue

### 1. Configurar el archivo .env

Crea o edita el archivo `.env` en `/var/www/grajalsin/Grajalsin/.env`:

```env
APP_NAME=Grajalsin
APP_ENV=production
APP_KEY=base64:TU_CLAVE_AQUI
APP_DEBUG=false
APP_URL=https://grajalsin.com.mx

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_datos
DB_USERNAME=usuario_bd
DB_PASSWORD=contraseña_bd

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Importante**: Genera la clave de aplicación con:
```bash
cd /var/www/grajalsin/Grajalsin
php artisan key:generate
```

### 2. Instalar Dependencias

```bash
cd /var/www/grajalsin/Grajalsin

# Instalar dependencias de PHP
composer install --no-dev --optimize-autoloader

# Instalar dependencias de Node.js
npm ci

# Compilar assets
npm run build
```

### 3. Configurar Base de Datos

```bash
# Ejecutar migraciones
php artisan migrate --force

# Si tienes seeders
php artisan db:seed --force
```

### 4. Configurar Permisos

```bash
sudo chown -R www-data:www-data /var/www/grajalsin/Grajalsin/storage
sudo chown -R www-data:www-data /var/www/grajalsin/Grajalsin/bootstrap/cache
sudo chmod -R 775 /var/www/grajalsin/Grajalsin/storage
sudo chmod -R 775 /var/www/grajalsin/Grajalsin/bootstrap/cache
```

### 5. Configurar Nginx

1. Copia el archivo de configuración:
```bash
sudo cp /var/www/grajalsin/nginx-grajalsin.conf /etc/nginx/sites-available/grajalsin.com.mx
```

2. Crea el enlace simbólico:
```bash
sudo ln -s /etc/nginx/sites-available/grajalsin.com.mx /etc/nginx/sites-enabled/
```

3. Verifica la configuración de Nginx:
```bash
sudo nginx -t
```

4. Si todo está bien, recarga Nginx:
```bash
sudo systemctl reload nginx
```

### 6. Optimizar Laravel para Producción

```bash
cd /var/www/grajalsin/Grajalsin

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 7. Usar el Script de Despliegue Automático

Puedes usar el script `deploy.sh` para automatizar el proceso:

```bash
chmod +x /var/www/grajalsin/deploy.sh
/var/www/grajalsin/deploy.sh
```

## Configuración de SSL (Opcional pero Recomendado)

Para habilitar HTTPS con Let's Encrypt:

```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-nginx

# Obtener certificado SSL
sudo certbot --nginx -d grajalsin.com.mx -d www.grajalsin.com.mx

# El certificado se renovará automáticamente
```

Después de obtener el certificado, descomenta la sección HTTPS en el archivo de configuración de Nginx.

## Comandos Útiles

### Ver logs de Laravel
```bash
tail -f /var/www/grajalsin/Grajalsin/storage/logs/laravel.log
```

### Ver logs de Nginx
```bash
sudo tail -f /var/log/nginx/error.log
sudo tail -f /var/log/nginx/access.log
```

### Limpiar caché
```bash
cd /var/www/grajalsin/Grajalsin
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reoptimizar después de cambios
```bash
cd /var/www/grajalsin/Grajalsin
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Solución de Problemas

### Error 502 Bad Gateway
- Verifica que PHP-FPM esté corriendo: `sudo systemctl status php8.2-fpm`
- Verifica los permisos de storage y bootstrap/cache
- Revisa los logs: `sudo tail -f /var/log/nginx/error.log`

### Error 500 Internal Server Error
- Verifica los logs de Laravel: `tail -f storage/logs/laravel.log`
- Verifica que APP_KEY esté configurado en .env
- Verifica permisos de archivos

### Assets no cargan
- Ejecuta `npm run build` nuevamente
- Verifica que la ruta `public/build` exista y tenga los archivos compilados

## Actualizaciones Futuras

Para actualizar el proyecto en producción:

```bash
cd /var/www/grajalsin/Grajalsin

# Actualizar código (git pull, etc.)
git pull origin main

# Ejecutar script de despliegue
/var/www/grajalsin/deploy.sh
```

