# Cómo Agregar un Nameserver en Hostinger

## 📋 Pasos para Agregar un Nameserver

### Opción 1: Agregar Nameserver en el Panel de Hostinger

1. **Inicia sesión en Hostinger:**
   - Ve a https://hpanel.hostinger.com
   - Inicia sesión con tu cuenta

2. **Accede a la configuración del dominio:**
   - Ve a **Dominios** → Selecciona **grajalsin.com.mx**
   - Busca la sección **"Nameservers"** o **"DNS Settings"**

3. **Agrega el nameserver:**
   - Busca un botón que diga **"Agregar Nameserver"**, **"Add Nameserver"**, o **"+"**
   - Ingresa el nameserver que quieres agregar (por ejemplo: `ns1.dns.hostinger.com`)
   - Guarda los cambios

### Opción 2: Cambiar a Nameservers Personalizados

Si quieres usar un solo nameserver o nameservers personalizados:

1. **En el panel de Hostinger:**
   - Ve a **Dominios** → **grajalsin.com.mx**
   - Busca **"Nameservers"** o **"DNS Settings"**
   - Selecciona **"Nameservers personalizados"** o **"Custom Nameservers"**

2. **Ingresa el nameserver:**
   ```
   ns1.dns.hostinger.com
   ```
   (O el nameserver que quieras usar)

3. **Guarda los cambios**

## ⚠️ Importante

- **Mínimo recomendado:** Generalmente se necesitan al menos 2 nameservers para redundancia
- **Si solo agregas uno:** El dominio funcionará, pero es mejor tener 2 para mayor confiabilidad
- **Tiempo de propagación:** 15 minutos a 48 horas (generalmente 15-30 minutos)

## 🔍 Verificar el Nameserver Agregado

Después de agregarlo, espera 15-30 minutos y verifica:

```bash
dig +short NS grajalsin.com.mx
```

Deberías ver el nameserver que agregaste en la lista.

## 📞 Si No Puedes Agregarlo en el Panel

Si no encuentras la opción para agregar nameservers:

1. **Contacta al soporte de Hostinger:**
   - Chat en vivo o ticket de soporte
   - Pide que agreguen un nameserver específico para `grajalsin.com.mx`

2. **Proporciona:**
   - El nombre del nameserver que quieres agregar
   - Confirma que quieres mantener los nameservers actuales y solo agregar uno más

## 💡 Recomendación

Si quieres usar solo un nameserver, considera usar:
- **Cloudflare** (gratis y rápido): `ns1.cloudflare.com` y `ns2.cloudflare.com`
- **Nameservers estándar de Hostinger**: Pregunta al soporte cuáles son

## ✅ Después de Agregar el Nameserver

1. Espera 15-30 minutos para la propagación
2. Verifica con: `dig +short NS grajalsin.com.mx`
3. Prueba el sitio: `curl -I http://grajalsin.com.mx`

