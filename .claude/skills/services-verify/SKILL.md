---
name: services-verify
description: Verificar página a página que la web reconstruida sobre el template coincide con la origen (paridad de URLs, contenido, meta/SEO y visual) y reportar los desajustes.
disable-model-invocation: true
allowed-tools: Read, Bash, WebFetch, mcp__playwright__browser_navigate, mcp__playwright__browser_snapshot, mcp__playwright__browser_evaluate, mcp__playwright__browser_take_screenshot
---

# Services · Verificar clon

Comprobar que la web reconstruida reproduce la origen. Cierra el pipeline de
clonado; no crea ni edita contenido, solo audita y reporta.

Entrada: URL del origen, URL del sitio reconstruido (local o staging) y
`storage/app/clone/inventory.json`. Salida: informe de paridad con desajustes.

## Qué verificar

### 1 — Paridad de URLs
Cruzar el sitemap del origen con el del reconstruido. Reportar URLs del origen sin
equivalente y URLs nuevas que no existían.

### 2 — Contenido por página
Para cada par origen↔destino: presencia de H1, encabezados de sección, copy clave
y atributos de servicio. Reportar lo que falte o difiera, no exigir literalidad.

### 3 — Meta y SEO
Comparar meta title, meta description y presencia de JSON-LD por página. Confirmar
que las inactivas devuelven 404 y no aparecen en el sitemap.

### 4 — Visual
`browser_take_screenshot` de home y páginas tipo en ambos sitios y comparar layout,
jerarquía y marca. Diferencias de píxel por fuentes/render no cuentan como fallo.

## Reportar

Checklist por bloque (URLs, contenido, SEO, visual) con estado y lista concreta de
desajustes priorizada. Si hay huecos: contenido → `/services-import-content`,
visual → `/services-clone-design`.
