# Estructura de Tablas - Base de Datos Grajalsin

**BD limpia.** Solo queda el usuario admin: `admin@grajalsin.com` / `admin123`

Cuando pases el Excel, compararé las columnas con estas tablas.

---

## Tablas del sistema

### **users**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| name | string | |
| email | string | único |
| email_verified_at | timestamp | nullable |
| password | string | |
| is_admin | boolean | default true |
| remember_token | string | nullable |
| created_at, updated_at | timestamps | |

---

### **productos**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| nombre | string | |
| codigo | string | único, nullable |
| descripcion | text | nullable |
| unidad_medida | string | default 'kg' |
| maneja_stock | boolean | default true |
| stock_actual | decimal(12,2) | default 0 |
| stock_minimo | decimal(12,2) | nullable |
| stock_maximo | decimal(12,2) | nullable |
| precio_compra | decimal(10,2) | nullable |
| precio_venta | decimal(10,2) | nullable |
| ubicacion | string | nullable |
| activo | boolean | default true |
| imagen | string | nullable |
| created_at, updated_at | timestamps | |
| deleted_at | timestamp | nullable (soft deletes) |

---

### **clientes**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| nombre | string | |
| codigo | string(10) | único, nullable |
| rfc | string(13) | nullable |
| contacto | string | nullable |
| telefono | string(20) | nullable |
| email | string | nullable |
| direccion | text | nullable |
| estatus | boolean | default true |
| notas | text | nullable |
| created_at, updated_at | timestamps | |

---

### **choferes**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| nombre | string | |
| telefono | string(20) | nullable |
| curp | string(18) | nullable |
| licencia_numero | string | nullable |
| licencia_tipo | string(20) | nullable |
| licencia_vence | date | nullable |
| estatus | boolean | default true |
| notas | text | nullable |
| created_at, updated_at | timestamps | |
| deleted_at | timestamp | nullable (soft deletes) |

---

### **bodegas**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| nombre | string | |
| clave | string(20) | nullable |
| ubicacion | string | nullable |
| estatus | boolean | default true |
| notas | text | nullable |
| created_at, updated_at | timestamps | |

---

### **destinos**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| nombre | string | |
| estado | string(100) | nullable |
| estatus | boolean | default true |
| notas | text | nullable |
| created_at, updated_at | timestamps | |

*Nota: La columna `tarifa` fue eliminada en una migración posterior.*

---

### **lineas_carga**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| nombre | string | |
| contacto | string | nullable |
| base_operacion | string | nullable |
| estatus | boolean | default true |
| notas | text | nullable |
| created_at, updated_at | timestamps | |

*Nota: telefono, email, direccion, rfc fueron eliminados en migración posterior.*

---

### **pre_ordenes**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| folio | string | nullable |
| fecha | date | |
| chofer_id | FK → choferes | |
| placa_tractor | string | |
| placa_remolque | string | |
| modelo | string | nullable |
| linea_carga_id | FK → lineas_carga | |
| poliza_seguro | string | nullable |
| destino_id | FK → destinos | |
| tarifa | decimal(10,2) | |
| cliente_id | FK → clientes | |
| coordinador_nombre | string | nullable |
| coordinador_telefono | string | nullable |
| constancia_fiscal | string | nullable |
| base_linea | string | nullable |
| precio_factura | decimal(10,2) | nullable |
| notas | text | nullable |
| created_at, updated_at | timestamps | |

*Nota: No tiene bodega_id. Los productos van en la tabla pivot `pre_orden_producto`.*

---

### **pre_orden_producto** (pivot: pre_orden ↔ producto)
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| pre_orden_id | FK → pre_ordenes | |
| producto_id | FK → productos | |
| cantidad | decimal(10,2) | nullable |
| tipo_carga | string | 'granel' o 'costal' |
| toneladas | decimal(10,2) | nullable |
| created_at, updated_at | timestamps | |

---

### **ordenes_carga**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| pre_orden_id | FK → pre_ordenes | |
| folio | string | único |
| fecha_entrada | date | |
| origen | string | nullable |
| bodega | string | nullable |
| destino | string | nullable |
| peso | string | nullable |
| producto | string | nullable |
| presentacion | string | nullable |
| costal | string | nullable |
| observaciones | text | nullable |
| operador_nombre | string | |
| operador_celular | string | nullable |
| operador_licencia | string | nullable |
| operador_curp | string | nullable |
| placas_camion | string | nullable |
| descripcion | string | nullable |
| linea | string | nullable |
| poliza | string | nullable |
| referencia | string | nullable |
| elaboro_nombre | string | |
| elaboro_celular | string | nullable |
| recibe_nombre | string | nullable |
| recibe_celular | string | nullable |
| created_at, updated_at | timestamps | |

---

### **boletas_salida**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| orden_carga_id | FK → ordenes_carga | único |
| folio | string | único |
| fecha | date | |
| cliente_tipo | string | nullable |
| cliente_nombre | string | |
| cliente_rfc | string | nullable |
| producto | string | |
| variedad | string | nullable |
| cosecha | string | nullable |
| envase | string | nullable |
| origen | string | nullable |
| destino | string | nullable |
| referencia | string | nullable |
| operador_nombre | string | |
| operador_celular | string | nullable |
| operador_licencia | string | nullable |
| operador_curp | string | nullable |
| camion | string | nullable |
| placas | string | nullable |
| poliza | string | nullable |
| linea | string | nullable |
| analisis_humedad | decimal(5,2) | nullable |
| analisis_peso_especifico | decimal(8,2) | nullable |
| analisis_impurezas | decimal(5,2) | nullable |
| analisis_quebrado | decimal(5,2) | nullable |
| analisis_danados | decimal(5,2) | nullable |
| analisis_otros | decimal(5,2) | nullable |
| peso_bruto | decimal(10,2) | nullable |
| peso_tara | decimal(10,2) | nullable |
| peso_neto | decimal(10,2) | nullable |
| peso_total | decimal(10,2) | nullable |
| observaciones | text | nullable |
| notas | text | nullable |
| elaboro_nombre | string | nullable |
| firma_recibio_nombre | string | nullable |
| created_at, updated_at | timestamps | |

---

### **servicio_logisticas**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| folio | string | único |
| cliente_id | FK → clientes | |
| tipo_unidad | enum | thermo, caja_seca, jaula, plataforma |
| tipo_carga | enum | simple, completa |
| linea_carga_id | FK → lineas_carga | |
| tarifa | decimal(10,2) | nullable |
| comision_porcentaje | decimal(5,2) | nullable |
| comision_monto | decimal(10,2) | nullable |
| chofer_id | FK → choferes | nullable |
| operador_nombre | string | nullable |
| operador_celular | string | nullable |
| operador_licencia_numero | string | nullable |
| operador_expediente_medico | string | nullable |
| operador_curp_rfc | string | nullable |
| placa_tractor | string | nullable |
| placa_remolque | string | nullable |
| modelo_color | string | nullable |
| poliza_compania | string | nullable |
| destino_id | FK → destinos | nullable |
| destino_carga | string | nullable |
| bodega | string | nullable |
| criba | string | nullable |
| cliente_empresa | string | nullable |
| coordinador_nombre | string | nullable |
| coordinador_numero | string | nullable |
| fecha | date | nullable |
| fecha_carga | date | nullable |
| fecha_destino | date | nullable |
| estado | enum | solicitado, en_contacto, orden_preparada, en_transito, en_destino, comision_pagada, completado |
| comision_pagada | boolean | default false |
| fecha_pago_comision | date | nullable |
| notas_monitoreo | text | nullable |
| tiene_carga_retorno | boolean | default false |
| servicio_retorno_id | bigint | nullable, FK → servicio_logisticas |
| notas_retorno | text | nullable |
| clave_interna | string | nullable |
| notas_internas | text | nullable |
| user_id | FK → users | |
| created_at, updated_at | timestamps | |
| deleted_at | timestamp | nullable (soft deletes) |

---

### **movimientos**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| producto_id | FK → productos | |
| tipo | enum | entrada, salida |
| motivo | enum | compra, venta, devolucion_cliente, devolucion_proveedor, ajuste_inventario, transferencia, otro |
| cantidad | decimal(12,2) | |
| precio_unitario | decimal(10,2) | nullable |
| total | decimal(12,2) | nullable |
| lote | string | nullable |
| referencia | string | nullable |
| notas | text | nullable |
| ubicacion_origen | string | nullable |
| ubicacion_destino | string | nullable |
| user_id | FK → users | |
| fecha_movimiento | timestamp | |
| created_at, updated_at | timestamps | |

---

### **perdidas**
| Columna | Tipo | Notas |
|---------|------|-------|
| id | bigint | PK |
| producto_id | FK → productos | |
| cantidad | decimal(12,2) | |
| tipo_perdida | string | |
| ubicacion | string | nullable |
| descripcion | text | nullable |
| acciones_tomadas | text | nullable |
| valor_estimado | decimal(10,2) | nullable |
| evidencia_foto | string | nullable |
| user_id | FK → users | |
| fecha_deteccion | timestamp | |
| created_at, updated_at | timestamps | |

---

## Resumen de tablas de negocio

| Tabla | Descripción |
|-------|-------------|
| productos | Granos/productos |
| clientes | Clientes |
| choferes | Operadores/choferes |
| bodegas | Bodegas/almacenes |
| destinos | Destinos de entrega |
| lineas_carga | Líneas de transporte |
| pre_ordenes | Pre-órdenes de carga |
| pre_orden_producto | Productos por pre-orden |
| ordenes_carga | Órdenes de carga |
| boletas_salida | Boletas de salida |
| servicio_logisticas | Servicios logísticos CATTA |
| movimientos | Movimientos de inventario |
| perdidas | Pérdidas de producto |

---

**Pasa el Excel** y te indico si las columnas coinciden con estas tablas o qué ajustes hacen falta.
