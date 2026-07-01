---
name: services-verify
description: Verificación final del clon completo — paridad de URLs, contenido, meta/SEO y visual entre la web origen y la reconstruida — y reporte de desajustes. Cierra el proceso de clonado, tras haber clonado todas las páginas 1 a 1.
disable-model-invocation: true
allowed-tools: Read, Bash, WebFetch, mcp__playwright__browser_navigate, mcp__playwright__browser_snapshot, mcp__playwright__browser_evaluate, mcp__playwright__browser_take_screenshot
---

# Services · Verificar clon (final)

Auditar el site entero una vez clonadas todas las páginas con `/services-clone-page`.
Cada página ya se verificó al clonarla; esto es la pasada global que caza lo que se
escapa página a página (huecos de cobertura, sitemap, coherencia). No crea ni edita
contenido, solo audita y reporta.

Entrada: URL del origen, URL del reconstruido (local o staging) y
`storage/app/clone/inventory.json`. Salida: informe de paridad con desajustes.

## Qué verificar

### 1 — Paridad de URLs
Cruzar el sitemap del origen con el del reconstruido. Reportar URLs del origen sin
equivalente y URLs nuevas que no existían en el origen.

### 2 — Contenido por página
Muestreo sobre cada tipo de página: presencia de H1, secciones, copy clave y
atributos. Reportar lo que falte o difiera; no exigir literalidad.

### 3 — Meta y SEO
Comparar meta title, meta description y presencia de JSON-LD por tipo de página.
Confirmar que las inactivas devuelven 404 y no salen en el sitemap.

### 4 — Visual
`browser_take_screenshot` de home y páginas tipo en ambos sitios y comparar layout,
jerarquía y marca. Diferencias de píxel por fuentes/render no cuentan como fallo.

## Reportar

Checklist por bloque (URLs, contenido, SEO, visual) con estado y lista priorizada de
desajustes. Si hay huecos: contenido/diseño de una página → volver a
`/services-clone-page` sobre esa página; falta una página entera → revisar el mapa de
`/services-map-source`.
