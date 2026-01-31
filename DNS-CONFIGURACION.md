# Configuración DNS para grajalsin.com.mx

## ✅ Estado Actual

Tu DNS está **correctamente configurado** y funcionando. El dominio ya está apuntando a tu servidor (84.32.84.32).

## 📋 Registros DNS Existentes

### 1. Registro A (Principal) - ✅ CORRECTO
```
Tipo: A
Nombre: @ (grajalsin.com.mx)
Valor: 84.32.84.32
TTL: 50
```
**Estado**: ✅ Funcionando correctamente
- Este registro apunta el dominio principal a tu servidor
- **Recomendación**: Cambiar TTL a 300 o 3600 para mejor rendimiento

### 2. Registro CNAME (www) - ✅ CORRECTO
```
Tipo: CNAME
Nombre: www
Valor: grajalsin.com.mx
TTL: 300
```
**Estado**: ✅ Funcionando correctamente
- Permite acceder al sitio con `www.grajalsin.com.mx`
- Redirige automáticamente al dominio principal

### 3. Registros de Email (Hostinger) - ✅ CORRECTO
```
MX @ 5  mx1.hostinger.com
MX @ 10 mx2.hostinger.com
```
**Estado**: ✅ Configurado para usar el servicio de email de Hostinger

**SPF (Sender Policy Framework)**:
```
TXT @ "v=spf1 include:_spf.mail.hostinger.com ~all"
```
**Estado**: ✅ Configurado para prevenir spam

**DMARC**:
```
TXT _dmarc "v=DMARC1; p=none"
```
**Estado**: ✅ Configurado (modo monitoreo)

**DKIM** (DomainKeys Identified Mail):
```
CNAME hostingermail-a._domainkey → hostingermail-a.dkim.mail.hostinger.com
CNAME hostingermail-b._domainkey → hostingermail-b.dkim.mail.hostinger.com
CNAME hostingermail-c._domainkey → hostingermail-c.dkim.mail.hostinger.com
```
**Estado**: ✅ Configurado para autenticación de emails

**Autodiscover/Autoconfig**:
```
CNAME autodiscover → autodiscover.mail.hostinger.com
CNAME autoconfig → autoconfig.mail.hostinger.com
```
**Estado**: ✅ Configurado para configuración automática de email

### 4. Registros CAA (Certificate Authority Authorization) - ✅ CORRECTO
```
CAA @ 0 issue "letsencrypt.org"
CAA @ 0 issue "digicert.com"
CAA @ 0 issue "sectigo.com"
... (y más)
```
**Estado**: ✅ Configurado para permitir certificados SSL de múltiples autoridades
- Permite obtener certificados SSL de Let's Encrypt, DigiCert, Sectigo, etc.

## 🔧 Recomendaciones de Optimización

### 1. Aumentar TTL del Registro A
**Actual**: TTL = 50 segundos
**Recomendado**: TTL = 300 o 3600 segundos

**Razón**: Un TTL muy bajo puede causar más consultas DNS innecesarias. Para producción, usa 300-3600 segundos.

**Cómo cambiarlo**:
1. Ve a tu panel de DNS de Hostinger
2. Edita el registro A de `@`
3. Cambia el TTL de 50 a 300 (o 3600)

### 2. Verificar que Nginx maneje www y no-www
Tu configuración de Nginx ya está lista para manejar ambos:
- `grajalsin.com.mx`
- `www.grajalsin.com.mx`

## ✅ Verificación de DNS

Para verificar que tu DNS está funcionando correctamente, ejecuta:

```bash
# Verificar registro A
dig +short grajalsin.com.mx A
# Debe mostrar: 84.32.84.32

# Verificar CNAME de www
dig +short www.grajalsin.com.mx CNAME
# Debe mostrar: grajalsin.com.mx.

# Verificar propagación completa
nslookup grajalsin.com.mx
```

## 🌐 Configuración de Nginx

Tu servidor Nginx ya está configurado para:
- ✅ Escuchar en el puerto 80 (HTTP)
- ✅ Responder a `grajalsin.com.mx` y `www.grajalsin.com.mx`
- ✅ Servir la aplicación Laravel desde `/var/www/grajalsin/Grajalsin/public`

## 🔒 Próximo Paso: Configurar SSL/HTTPS

Una vez que el DNS esté completamente propagado (puede tardar hasta 48 horas, pero generalmente es más rápido), puedes instalar un certificado SSL:

```bash
# Instalar Certbot
sudo apt install certbot python3-certbot-nginx

# Obtener certificado SSL gratuito de Let's Encrypt
sudo certbot --nginx -d grajalsin.com.mx -d www.grajalsin.com.mx

# El certificado se renovará automáticamente
```

Después de obtener el certificado SSL:
1. Descomenta la sección HTTPS en `/etc/nginx/sites-available/grajalsin.com.mx`
2. Recarga Nginx: `sudo systemctl reload nginx`

## 📝 Resumen

| Componente | Estado | Acción Requerida |
|------------|--------|------------------|
| Registro A | ✅ Funcionando | Opcional: Aumentar TTL |
| CNAME www | ✅ Funcionando | Ninguna |
| Email (MX/SPF/DMARC/DKIM) | ✅ Configurado | Ninguna |
| CAA Records | ✅ Configurado | Ninguna |
| Nginx | ✅ Configurado | Ninguna |
| SSL/HTTPS | ⏳ Pendiente | Instalar certificado |

## 🎉 Conclusión

**Tu DNS está correctamente configurado y funcionando.** El dominio `grajalsin.com.mx` ya está apuntando a tu servidor (84.32.84.32) y el sitio web está accesible.

La única mejora opcional es aumentar el TTL del registro A de 50 a 300 segundos para mejor rendimiento.

