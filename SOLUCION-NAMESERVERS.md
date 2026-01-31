# Solución: Cambiar Nameservers de Parking

## 🔍 Problema Identificado

Tu dominio está usando **nameservers de parking** de Hostinger:
- `ns1.dns-parking.com`
- `ns2.dns-parking.com`

Estos nameservers interceptan TODAS las conexiones y muestran la página de parking de Hostinger, incluso aunque el registro A apunte correctamente a `84.32.84.32`.

## ✅ Solución: Cambiar Nameservers

### Paso 1: Acceder al Panel de Hostinger

1. Inicia sesión en tu cuenta de Hostinger
2. Ve a **Dominios** → **grajalsin.com.mx**
3. Busca la sección **"Nameservers"** o **"DNS"**

### Paso 2: Cambiar los Nameservers

**Opción A: Usar los nameservers estándar de Hostinger**

Cambia de:
```
ns1.dns-parking.com
ns2.dns-parking.com
```

A los nameservers estándar de Hostinger (pregunta al soporte cuáles son, generalmente son algo como):
```
ns1.dns.hostinger.com
ns2.dns.hostinger.com
```

**Opción B: Usar nameservers personalizados (si tienes acceso)**

Si tienes acceso a configurar nameservers personalizados, puedes usar:
- Cloudflare (recomendado - gratuito y rápido)
- Los nameservers de tu proveedor de hosting

### Paso 3: Verificar el Cambio

Después de cambiar los nameservers, espera 15-30 minutos y verifica:

```bash
dig +short NS grajalsin.com.mx
```

**Debe mostrar los nuevos nameservers**, NO los de parking.

### Paso 4: Verificar que Funciona

Una vez que los nameservers se hayan propagado:

```bash
# Verificar que el sitio funciona
curl -I http://grajalsin.com.mx
```

## 📋 Instrucciones Detalladas para Hostinger

### En el Panel de Hostinger:

1. **Ve a tu dominio:**
   - Inicia sesión en hpanel.hostinger.com
   - Ve a **Dominios** → Selecciona **grajalsin.com.mx**

2. **Busca "Nameservers" o "DNS Settings":**
   - Busca una sección llamada "Nameservers", "DNS Settings", o "Zona DNS"
   - Si no la encuentras, busca "Advanced DNS" o "DNS Management"

3. **Cambia los nameservers:**
   - Si ves `ns1.dns-parking.com` y `ns2.dns-parking.com`, cámbialos
   - Usa los nameservers estándar de Hostinger (pregunta al soporte si no los conoces)

4. **Guarda los cambios:**
   - Guarda la configuración
   - Espera 15-30 minutos para la propagación

## ⚠️ Importante

- **Los nameservers de parking están activos** - por eso ves la página de Hostinger
- **El registro A está correcto** (84.32.84.32) pero no se usa porque los nameservers de parking interceptan todo
- **Después de cambiar los nameservers**, el dominio funcionará correctamente

## 🔄 Tiempo de Propagación

- **Cambio de nameservers**: 15 minutos a 48 horas (generalmente 15-30 minutos)
- **Verificación**: Usa `dig +short NS grajalsin.com.mx` para verificar

## 📞 Si No Puedes Cambiar los Nameservers

Si no tienes acceso para cambiar los nameservers en el panel de Hostinger:

1. **Contacta al soporte de Hostinger** y pide que:
   - Desactiven el "DNS Parking" para `grajalsin.com.mx`
   - Cambien los nameservers a los estándar de Hostinger
   - Confirmen que el dominio ya no usa `ns1.dns-parking.com` y `ns2.dns-parking.com`

2. **Menciona específicamente:**
   - "Mi dominio está usando nameservers de parking (ns1.dns-parking.com y ns2.dns-parking.com)"
   - "Necesito que cambien los nameservers para que el dominio funcione correctamente"
   - "El registro A ya está configurado correctamente (84.32.84.32)"

## ✅ Después del Cambio

Una vez que los nameservers se hayan cambiado y propagado:

1. El dominio funcionará correctamente
2. Podrás instalar SSL con Certbot
3. El sitio será accesible en `http://grajalsin.com.mx` y `https://grajalsin.com.mx`

## 🎯 Resumen

**Problema:** Nameservers de parking interceptan todas las conexiones
**Solución:** Cambiar nameservers en el panel de Hostinger
**Tiempo:** 15-30 minutos después del cambio

