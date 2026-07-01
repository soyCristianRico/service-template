---
name: services-import-content
description: Cargar el inventario de una web clonada (categorías, servicios, ubicaciones, landings, blog, páginas) en la app vía el MCP de contenido del sitio, con dedup y en el orden correcto de dependencias.
disable-model-invocation: true
allowed-tools: Read, Bash, Write
---

# Services · Importar contenido

Volcar el inventario de `/services-crawl-source` en la base de datos del sitio a
través del **MCP de contenido** (`/mcp/services`). Solo carga contenido de DB; el
home/hero/layouts son Blade en git y los maneja `/services-clone-design`.

Entrada: `storage/app/clone/inventory.json`. Requisito: el MCP del sitio añadido
como cliente (token de `php artisan services:mcp-token`). Sus tools (list/create/
update de Categories, Services, Locations, Landings —incl. bulk-create—, Blog y
Pages) se localizan con ToolSearch antes de empezar.

## Orden de carga (respeta dependencias)

1. **Categorías** — árbol primero las raíz, luego hijas (`parent_id`).
2. **Servicios** — cada uno a su categoría; atributos propios en `custom_fields`.
3. **Ubicaciones** — árbol país → región → provincia → ciudad → distrito.
4. **Landings** — categoría×ubicación. Usar bulk-create para el grueso y luego
   update para el copy (title/H1, intro, meta) de las importantes.
5. **Blog** — `published_at` en pasado publica, en futuro programa, `null` borrador.
6. **Páginas** — estáticas (aviso legal, gracias, sobre nosotros, contacto).

## Proceso

### 1 — Dedup antes de crear
Para cada entidad, `list-*` filtrando por slug/nombre y saltar lo que ya exista.
Los create/bulk hacen upsert por slug, pero comprobar evita slugs casi-duplicados.

### 2 — Cargar en orden
Recorrer las 6 entidades en el orden de arriba, resolviendo ids de la entidad
padre antes de crear la hija. Slugs en minúscula-con-guiones.

### 3 — Estado
Copia exacta = reflejar el estado del origen: lo que está publicado se activa, lo
demás queda inactivo. Las landings se pueden activar por tandas, no todas de golpe.

### 4 — Reportar
Conteo creado/actualizado/saltado por entidad y URLs públicas de muestra.
Recordar que home/hero/diseño van aparte: siguiente paso `/services-clone-design`.

## Guardarraíles

- No fabricar datos: campo `null` en el inventario se queda `null`.
- No cargar leads ni cuentas: no viven en este MCP.
- Verificar la paridad de conteo origen↔destino con `/services-verify` al cerrar.
