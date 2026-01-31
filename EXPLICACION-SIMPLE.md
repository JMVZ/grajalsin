# Explicación Simple del Problema

## 🔍 ¿Qué está pasando?

Tu dominio `grajalsin.com.mx` está configurado para mostrar la página de Hostinger en lugar de tu sitio web.

## ❌ El Problema

Hostinger tiene activo un servicio llamado "DNS Parking" que está interceptando todas las visitas a tu dominio y mostrando su página de "dominio registrado" en lugar de tu sitio web.

## ✅ La Solución (Pasos Simples)

### Paso 1: Entra a Hostinger
1. Ve a: https://hpanel.hostinger.com
2. Inicia sesión con tu cuenta

### Paso 2: Ve a tu dominio
1. Busca la sección **"Dominios"** en el menú
2. Haz clic en **"grajalsin.com.mx"**

### Paso 3: Busca "Nameservers" o "DNS"
1. Busca una sección que diga:
   - "Nameservers"
   - "DNS Settings" 
   - "Configuración DNS"
   - "Zona DNS"

### Paso 4: Cambia los Nameservers
Actualmente tienes:
- `ns1.dns-parking.com`
- `ns2.dns-parking.com`

**Necesitas cambiarlos** por los nameservers estándar de Hostinger.

**¿Cuáles son los nameservers correctos?**
- Pregunta al soporte de Hostinger por chat o email
- O busca en la documentación de Hostinger
- Generalmente son algo como: `ns1.dns.hostinger.com` y `ns2.dns.hostinger.com`

### Paso 5: Guarda y Espera
1. Guarda los cambios
2. Espera 15-30 minutos
3. Prueba tu sitio: http://grajalsin.com.mx

## 📞 Si No Sabes Cómo Hacerlo

**Contacta al soporte de Hostinger** y diles:

> "Hola, mi dominio grajalsin.com.mx está mostrando la página de parking de Hostinger en lugar de mi sitio web. Necesito que cambien los nameservers de parking (ns1.dns-parking.com y ns2.dns-parking.com) a los nameservers estándar de Hostinger para que mi dominio funcione correctamente."

## 🎯 Resumen en 3 Puntos

1. **Problema:** Hostinger está mostrando su página en lugar de tu sitio
2. **Causa:** Los nameservers están en modo "parking"
3. **Solución:** Cambiar los nameservers en el panel de Hostinger

## ⏰ Tiempo

Después de cambiar los nameservers, espera 15-30 minutos y tu sitio debería funcionar.

