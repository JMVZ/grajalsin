# Explicación del Aviso de Contraseña

## ¿Por qué sale el aviso?

Laravel tiene validación de contraseñas que verifica:
- ✅ Mínimo 8 caracteres
- ✅ Puede detectar contraseñas comunes o débiles
- ✅ Muestra advertencias de seguridad

La contraseña `admin123` es una contraseña predeterminada y Laravel puede mostrar un aviso de seguridad recomendando cambiarla.

## ¿Es un problema?

**NO**, no es un problema. Es una **recomendación de seguridad** de Laravel.

El aviso aparece porque:
1. Es una contraseña predeterminada
2. Es relativamente simple
3. Laravel recomienda usar contraseñas más seguras

## Soluciones

### Opción 1: Cambiar la contraseña (RECOMENDADO)

1. Inicia sesión con `admin@grajalsin.com` / `admin123`
2. Ve a tu perfil
3. Cambia la contraseña por una más segura

### Opción 2: Ignorar el aviso

Si es solo para desarrollo o pruebas, puedes ignorar el aviso. La contraseña funciona correctamente.

### Opción 3: Desactivar validación estricta (NO RECOMENDADO)

Si realmente necesitas desactivar las validaciones estrictas de contraseña, puedes modificar los controladores, pero **NO es recomendado** por seguridad.

## Recomendación

**Cambia la contraseña** después del primer inicio de sesión por una más segura:
- Mínimo 8 caracteres
- Incluir mayúsculas, minúsculas, números
- Incluir símbolos si es posible

## Conclusión

El aviso es **normal y esperado**. Es una característica de seguridad de Laravel que te recuerda usar contraseñas seguras. Puedes:
- ✅ Cambiar la contraseña (recomendado)
- ✅ Ignorar el aviso si es temporal
- ❌ NO desactivar las validaciones de seguridad

