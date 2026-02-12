# Importar datos desde Excel

## Comando

```bash
cd Grajalsin
php artisan importar:excel --carpeta="/ruta/a/tu/carpeta"
```

## Archivos esperados

Coloca los archivos Excel en una carpeta y pasa la ruta con `--carpeta`:

| Archivo | Tabla | Columnas |
|---------|-------|----------|
| RELACION DE BODEGAS.xlsx | bodegas | NOMBRE BODEGA, UBICACIÓN, CLAVE |
| RELACION DE CHOFERES.xlsx | choferes | NOMBRE:, TELEFONO, CURP O RFC, LICENCIA |
| RELACION DE PRODUCTOS.xlsx | productos | PRODUCTO, UNDAD, CODIGO |
| RELACION DESTINOS.xlsx | destinos | DESTINO, ESTADO |

## Opciones

Importar todos desde una carpeta:
```bash
php artisan importar:excel --carpeta="/Users/jm/Downloads"
```

Importar archivos específicos:
```bash
php artisan importar:excel \
  --bodegas="/ruta/RELACION DE BODEGAS.xlsx" \
  --choferes="/ruta/RELACION DE CHOFERES.xlsx" \
  --productos="/ruta/RELACION DE PRODUCTOS.xlsx" \
  --destinos="/ruta/RELACION DESTINOS.xlsx"
```

Importar solo uno:
```bash
php artisan importar:excel --productos="/ruta/RELACION DE PRODUCTOS.xlsx"
```

## Mapeo de columnas

- **Bodegas:** NOMBRE BODEGA → nombre, UBICACIÓN → ubicacion, CLAVE → clave
- **Choferes:** NOMBRE: → nombre, TELEFONO → telefono, CURP O RFC → curp, LICENCIA → licencia_numero
- **Productos:** PRODUCTO → nombre, UNDAD → unidad_medida, CODIGO → codigo
- **Destinos:** DESTINO → nombre, ESTADO → estado

Los registros existentes se actualizan por nombre (o codigo en productos).
