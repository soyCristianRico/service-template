---
name: services-extract-design
description: Extraer el sistema visual de la web de servicios actual (colores, tipografías, escalas, logo) y volcarlo en DESIGN.md + tokens de Tailwind del template. Tercer paso (global) del clonado; deja la base visual sobre la que se replica cada página.
disable-model-invocation: true
allowed-tools: Read, Write, Edit, Bash, WebFetch, mcp__playwright__browser_navigate, mcp__playwright__browser_evaluate, mcp__playwright__browser_take_screenshot, Skill
---

# Services · Extraer diseño de la web actual

Generar el `DESIGN.md` del template **a partir de lo que hay hoy en la web origen**,
no de un brief nuevo. Es la base visual global; la réplica de secciones página a
página la hace `/services-clone-page`.

Entrada: URL de la web origen (+ capturas de `/services-map-source`). Salidas:
`DESIGN.md` y el bloque `@theme` de `resources/css/app.css`, más logo/favicon/OG en
`public/`.

## Proceso

### 1 — Extraer la marca del origen
Con Playwright abrir home + una página tipo y `browser_evaluate` sobre estilos
computados: paleta de color, familias tipográficas y escalas, radios, sombras,
espaciados. Descargar logo, favicon y OG. `browser_take_screenshot` de referencia.

### 2 — Generar el sistema de diseño
Pasar la marca extraída a la skill `/design-system-from-brief`, que escribe
`DESIGN.md` y los tokens `@theme`. Colocar logo/favicon/OG en `public/`.

### 3 — Comprobar la base
Levantar el template en local y confirmar que los tokens (color, tipografía,
radios) coinciden con el origen en un vistazo. Aún sin replicar secciones: eso es
por página.

### 4 — Reportar
Tokens definidos y assets colocados. Siguiente paso: `/services-clone-page` (bucle
página a página).

## Cuándo parar

Cuando color, tipografía y assets del template reflejen los del origen. El detalle
de cada sección se ajusta después, página a página.
