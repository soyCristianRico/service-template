---
name: services-crawl-source
description: Rastrear una web de servicios ya publicada y volcar todo su contenido (sitemap, textos, servicios, ubicaciones, landings, blog, páginas) a un inventario JSON mapeado al modelo del template. Primer paso para clonar una web existente.
disable-model-invocation: true
allowed-tools: WebFetch, Bash, Read, Write, mcp__playwright__browser_navigate, mcp__playwright__browser_snapshot, mcp__playwright__browser_evaluate, mcp__playwright__browser_take_screenshot
---

# Services · Rastrear web origen

Extraer TODO el contenido de una web de servicios publicada y dejarlo en un
inventario JSON. Solo extrae y mapea; no crea nada en la app (eso es
`/services-import-content`) ni toca el diseño (eso es `/services-clone-design`).

Entrada: URL de la web origen. Salida: `storage/app/clone/inventory.json`.

## Modelo destino

Mapear cada URL del origen a una de estas entidades del template:

| Entidad | Qué es en el origen |
|---------|---------------------|
| `categories` | Familias de servicio (árbol) |
| `services` | Cada servicio/producto (atributos propios → `custom_fields`) |
| `locations` | Ubicaciones (árbol: país → región → provincia → ciudad → distrito) |
| `landings` | Páginas categoría×ubicación (`/{categoría}-{ubicación}`) |
| `blog` | Entradas de blog |
| `pages` | Estáticas: aviso legal, gracias, sobre nosotros, contacto |
| `home` (no MCP) | Home/hero/secciones: es Blade en git, va a `/services-clone-design`, aquí solo se anota su estructura |

## Proceso

### 1 — Reunir URLs
- Leer `origen/sitemap.xml` (y sub-sitemaps si los hay). Si no existe, rastrear
  desde la home siguiendo enlaces internos.
- Para JS pesado usar Playwright (`browser_navigate` + `browser_snapshot`);
  para HTML plano basta `WebFetch`.

### 2 — Clasificar
- Etiquetar cada URL con su entidad destino según patrón de ruta y contenido.
- Detectar el patrón de landing: `A) carpetas /{categoría}/{ubicación}`,
  `B) slug plano /{categoría}-{ubicación}`, o `C) sin ubicaciones` (solo
  categorías/servicios + estáticas). Anotar cuál aplica.

### 3 — Extraer por página
Para cada URL: `title`, meta title, meta description, H1, encabezados de sección,
copy del cuerpo, CTAs, atributos del servicio (kVA, m³, dB… → `custom_fields`) y
URLs de imágenes. No inventar: campo que no se verifique va `null`.

### 4 — Volcar inventario
- Escribir `storage/app/clone/inventory.json` con las claves del modelo destino,
  slugs en minúscula-con-guiones, y las relaciones resueltas (servicio→categoría,
  landing→categoría+ubicación).
- Guardar aparte la lista de imágenes a descargar y la estructura de la home.

### 5 — Reportar
- Conteo por entidad, patrón de landing detectado (A/B/C), y URLs que no se
  pudieron clasificar. Siguiente paso: `/services-import-content`.

## Cuándo parar

Cuando el sitemap esté agotado y una ronda de rastreo no aporte tipos de página
nuevos. Variaciones de la misma plantilla no hace falta abrirlas una a una: basta
una de muestra para fijar el mapeo.
