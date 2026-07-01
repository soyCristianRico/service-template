---
name: services-clone-page
description: Clonar UNA página de la web origen de principio a fin — contenido, diseño y verificación — sobre el registro esqueleto ya creado. Es el motor del bucle 1-a-1: se ejecuta una página cada vez y se valida antes de seguir.
disable-model-invocation: true
allowed-tools: Read, Write, Edit, Bash, WebFetch, mcp__playwright__browser_navigate, mcp__playwright__browser_snapshot, mcp__playwright__browser_evaluate, mcp__playwright__browser_take_screenshot
---

# Services · Clonar página (1 a 1)

Reproducir **una sola página** del origen completa: su contenido, sus secciones
visuales y su verificación, en una pasada. Se ejecuta página a página, no en lote:
menos blast radius y checkpoint humano por página.

Requisitos previos: `/services-scaffold-structure` (registro esqueleto ya creado) y
`/services-extract-design` (`DESIGN.md` + tokens listos).

Entrada: la página a clonar (URL origen + su entrada en `inventory.json`). Salida:
esa página clonada y verificada, lista para revisión.

## Proceso (para UNA página)

### 1 — Contenido
Rellenar el registro esqueleto de esa página (servicio / landing / página estática /
entrada de blog) con su copy real, meta title/description, atributos (`custom_fields`)
e imágenes, tomados del origen. Reflejar el estado activo/inactivo del origen.

### 2 — Diseño
Replicar en Blade las secciones concretas de esa página (según el mapa de
`/services-map-source`), respetando el `DESIGN.md` y los componentes Flux del
template. No copiar CSS crudo: traducir a los tokens `@theme`.

### 3 — Verificar
`browser_take_screenshot` de la página origen y de la reconstruida y comparar lado a
lado: secciones, jerarquía, copy clave, meta. Reportar coincidencias y desajustes.

### 4 — Parar para revisión
Presentar la página clonada (URL local + comparación) y **esperar validación** antes
de pasar a la siguiente. Si hay que corregir, iterar sobre esta misma página.

## Guardarraíles

- Una página por ejecución. No encadenar páginas sin validación intermedia.
- No inventar copy: lo que no esté en el origen, no se pone.
- Trabajar sobre el registro esqueleto existente; no recrear estructura.
- Al terminar todas las páginas: verificación global con `/services-verify`.
