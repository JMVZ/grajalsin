# Configuración Correcta del Dominio

## ✅ Configuración Actual

**Registro A correcto:**
```
A    @    31.97.11.87
```

**Servidor:** `31.97.11.87` está funcionando correctamente ✅

## ⏰ Propagación DNS

Después de cambiar el registro A de `84.32.84.32` a `31.97.11.87`, el DNS puede tardar:

- **Mínimo:** 5-15 minutos
- **Máximo:** 24-48 horas
- **Promedio:** 30 minutos a 2 horas

## 🔍 Verificar que Funciona

Después de esperar 15-30 minutos, verifica:

```bash
# Verificar DNS
dig +short grajalsin.com.mx A
# Debe mostrar: 31.97.11.87

# Verificar que el sitio funciona
curl -I http://grajalsin.com.mx
# Debe mostrar: HTTP/1.1 200 OK (no la página de Hostinger)
```

## ⚠️ Si Todavía Muestra la Página de Hostinger

Si después de cambiar el registro A a `31.97.11.87` todavía ves la página de Hostinger:

1. **Espera más tiempo** (hasta 2 horas)
2. **Limpia la caché DNS:**
   - En Windows: `ipconfig /flushdns`
   - En Mac/Linux: `sudo systemd-resolve --flush-caches`
3. **Verifica los nameservers:**
   ```bash
   dig +short NS grajalsin.com.mx
   ```
   Si todavía muestra `ns1.dns-parking.com` y `ns2.dns-parking.com`, necesitas cambiarlos.

## ✅ Estado Actual

- ✅ Registro A: `31.97.11.87` (correcto)
- ✅ Servidor: Funcionando correctamente
- ⏳ DNS: Propagándose (espera 15-30 minutos)

