---
name: services-map-source
description: Dimensionar y documentar una web de servicios publicada — qué páginas hay y qué secciones tiene cada una — en un documento revisable más un inventario JSON. Primer paso (global) para clonar una web existente.
disable-model-invocation: true
allowed-tools: WebFetch, Bash, Read, Write, mcp__playwright__browser_navigate, mcp__playwright__browser_snapshot, mcp__playwright__browser_evaluate, mcp__playwright__browser_take_screenshot
---

# Services · Dimensionar web origen

Levantar el mapa completo de la web origen: inventario de páginas y, por cada una,
sus secciones. Solo documenta; no crea estructura (eso es
`/services-scaffold-structure`) ni clona páginas (eso es `/services-clone-page`).

Entrada: URL de la web origen. Salidas:
- `storage/app/clone/mapa.md` — documento legible para revisar (páginas + secciones).
- `storage/app/clone/inventory.json` — mismo mapa en datos, para las skills siguientes.

## Modelo destino

Clasificar cada página en una entidad del template: `categories`, `services`
(atributos propios → `custom_fields`), `locations` (árbol país → región → provincia
→ ciudad → distrito), `landings` (categoría×ubicación), `blog`, `pages` (estáticas).
La home y sus secciones son Blade en git: se documentan, no son entidad de BD.

## Proceso

### 1 — Reunir URLs
Leer `origen/sitemap.xml` (y sub-sitemaps). Si no hay, rastrear desde la home por
enlaces internos. JS pesado → Playwright; HTML plano → `WebFetch`.

### 2 — Clasificar y detectar patrón
Etiquetar cada URL con su entidad. Detectar el patrón de landing:
`A) carpetas /{categoría}/{ubicación}`, `B) slug plano /{categoría}-{ubicación}`,
o `C) sin ubicaciones`. Anotar cuál aplica.

### 3 — Documentar secciones por página
Para cada página: título, meta, H1, y la **lista ordenada de secciones** (hero,
bloques de servicios, prueba social, FAQ, CTA, footer…) con su copy y las imágenes.
Atributos de servicio (kVA, m³, dB…) → `custom_fields`. No inventar: sin verificar,
`null`.

### 4 — Escribir salidas
`mapa.md` agrupado por tipo de página, con las secciones de cada una en orden, para
que sea revisable de un vistazo. `inventory.json` con las entidades, slugs en
minúscula-con-guiones y relaciones resueltas (servicio→categoría, landing→categoría
+ubicación).

### 5 — Reportar
Conteo por entidad, patrón de landing (A/B/C) y páginas sin clasificar. Siguiente
paso: `/services-scaffold-structure`.

## Cuándo parar

Cuando el sitemap esté agotado y una ronda no aporte tipos de página nuevos. Basta
una página de muestra por plantilla repetida para fijar el mapeo.
