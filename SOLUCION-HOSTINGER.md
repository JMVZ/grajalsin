# Solución: Hostinger muestra página de parking en HTTPS

## 🔍 Problema Identificado

Cuando accedes a `https://grajalsin.com.mx`, Hostinger está interceptando la conexión y mostrando su página de parking/hosting en lugar de dejar que la conexión llegue a tu servidor (84.32.84.32).

**Estado actual:**
- ✅ HTTP funciona: `http://grajalsin.com.mx` → Tu servidor (200 OK)
- ❌ HTTPS interceptado: `https://grajalsin.com.mx` → Página de Hostinger

## 🛠️ Soluciones

### Solución 1: Desactivar servicios de Hostinger (RECOMENDADO)

Hostinger puede tener activos servicios que interceptan HTTPS:

1. **Accede a tu panel de Hostinger**
2. **Ve a la sección de Dominios**
3. **Busca "grajalsin.com.mx"**
4. **Desactiva cualquier servicio activo:**
   - ❌ Desactiva "Website Builder" si está activo
   - ❌ Desactiva "Hosting" si no lo estás usando
   - ❌ Desactiva "Parking Page" si está activo
   - ❌ Desactiva cualquier CDN o proxy de Hostinger

5. **Verifica los Nameservers:**
   - Si estás usando los nameservers de Hostinger, asegúrate de que no tengan servicios activos
   - O cambia a nameservers personalizados si tienes acceso

### Solución 2: Instalar certificado SSL en tu servidor

Una vez que desactives los servicios de Hostinger, instala un certificado SSL en tu servidor:

```bash
# 1. Instalar Certbot
sudo apt update
sudo apt install certbot python3-certbot-nginx -y

# 2. Obtener certificado SSL gratuito de Let's Encrypt
sudo certbot --nginx -d grajalsin.com.mx -d www.grajalsin.com.mx

# 3. El certificado se renovará automáticamente
```

Esto configurará automáticamente HTTPS en tu servidor.

### Solución 3: Verificar configuración de DNS en Hostinger

Asegúrate de que:

1. **El registro A apunta correctamente:**
   ```
   Tipo: A
   Nombre: @
   Valor: 84.32.84.32
   TTL: 300
   ```

2. **No hay registros CNAME conflictivos:**
   - Solo debe haber un CNAME para `www` → `grajalsin.com.mx`
   - No debe haber CNAME para `@` (el dominio raíz)

3. **No hay servicios de redirección activos:**
   - Verifica que no haya redirecciones HTTP → HTTPS configuradas en Hostinger
   - Verifica que no haya "Forzar HTTPS" activo en Hostinger

## 📋 Pasos Inmediatos

### Paso 1: Verificar en Hostinger

1. Inicia sesión en tu cuenta de Hostinger
2. Ve a **Dominios** → **grajalsin.com.mx**
3. Busca secciones como:
   - "Website Builder"
   - "Hosting"
   - "Parking Page"
   - "CDN"
   - "Proxy"
4. **Desactiva todos los servicios** que no estés usando

### Paso 2: Verificar DNS

En el panel de DNS de Hostinger, verifica:

```
✅ A     @    84.32.84.32
✅ CNAME www  grajalsin.com.mx
```

### Paso 3: Instalar SSL en tu servidor

Una vez que Hostinger deje de interceptar HTTPS:

```bash
# En tu servidor (84.32.84.32)
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d grajalsin.com.mx -d www.grajalsin.com.mx
```

### Paso 4: Verificar que funciona

```bash
# Verificar HTTP
curl -I http://grajalsin.com.mx

# Verificar HTTPS (después de instalar SSL)
curl -I https://grajalsin.com.mx
```

## 🔧 Configuración Actual del Servidor

Tu servidor ya está configurado para:
- ✅ Escuchar en puerto 80 (HTTP)
- ✅ Escuchar en puerto 443 (HTTPS) - listo para SSL
- ✅ Servir Laravel desde `/var/www/grajalsin/Grajalsin/public`
- ✅ Responder a `grajalsin.com.mx` y `www.grajalsin.com.mx`

## ⚠️ Nota Importante

**Hostinger puede tardar hasta 24-48 horas** en desactivar completamente sus servicios después de que los desactives en el panel. Si después de desactivar los servicios sigue mostrando la página de Hostinger:

1. Espera 24 horas
2. Limpia la caché de DNS: `sudo systemd-resolve --flush-caches` (en tu servidor)
3. Verifica desde diferentes ubicaciones: https://www.whatsmydns.net/#A/grajalsin.com.mx

## 📞 Si el problema persiste

Si después de seguir estos pasos el problema continúa:

1. **Contacta al soporte de Hostinger** y pide que:
   - Desactiven completamente todos los servicios para `grajalsin.com.mx`
   - Verifiquen que no hay proxies o CDN activos
   - Confirmen que el DNS apunta directamente a 84.32.84.32

2. **Verifica que no hay conflictos:**
   ```bash
   # Desde tu servidor
   dig +short grajalsin.com.mx A
   # Debe mostrar: 84.32.84.32
   ```

## ✅ Resumen

**Problema:** Hostinger intercepta HTTPS y muestra su página de parking

**Solución:**
1. Desactivar servicios de Hostinger en el panel
2. Instalar certificado SSL en tu servidor
3. Esperar propagación (24-48 horas)

**Estado del servidor:** ✅ Listo y funcionando (HTTP funciona perfectamente)

