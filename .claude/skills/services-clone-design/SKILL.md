---
name: services-clone-design
description: Replicar la identidad visual y las secciones Blade (home, hero, layouts) de una web de servicios origen sobre el template, extrayendo marca con Playwright y aplicándola vía DESIGN.md y código.
disable-model-invocation: true
allowed-tools: Read, Write, Edit, Bash, WebFetch, mcp__playwright__browser_navigate, mcp__playwright__browser_snapshot, mcp__playwright__browser_evaluate, mcp__playwright__browser_take_screenshot, Skill
---

# Services · Clonar diseño

Reproducir el aspecto del origen sobre el template: sistema de diseño (colores,
tipos, logo) y las secciones hardcodeadas en Blade (home, hero, features, footer)
que NO viven en el MCP de contenido. El contenido de DB lo carga
`/services-import-content`; aquí va lo visual y el Blade en git.

Entrada: URL del origen (+ imágenes/estructura de home que dejó
`/services-crawl-source`). Salida: `DESIGN.md` + `@theme` en `resources/css/app.css`
actualizados y las vistas Blade ajustadas.

## Proceso

### 1 — Extraer marca del origen
- Con Playwright abrir home + una página tipo, `browser_evaluate` para leer estilos
  computados: paleta de color, familias tipográficas, escalas, radios, sombras.
- Descargar logo, favicon y OG. `browser_take_screenshot` de home y secciones clave
  como referencia visual.

### 2 — Generar el sistema de diseño
- Pasar la marca extraída (colores, tipos, tono visual) a la skill
  `/design-system-from-brief`, que escribe `DESIGN.md` y el bloque `@theme` de
  Tailwind. Colocar logo/favicon en `public/`.

### 3 — Replicar secciones Blade
- Reproducir en las vistas de `resources/views` la estructura de la home y secciones
  del origen (hero, bloques de servicios, prueba social, CTA, footer), respetando
  el sistema de diseño ya generado y los componentes Flux del template.
- No copiar CSS crudo del origen: traducir a los tokens de `@theme`.

### 4 — Iterar contra el original
- `browser_take_screenshot` de la web reconstruida y comparar lado a lado con la
  captura del origen. Ajustar hasta que coincidan layout, jerarquía y marca.

### 5 — Reportar
Secciones replicadas, tokens definidos y desajustes pendientes. Verificación final
página a página en `/services-verify`.

## Cuándo parar

Cuando home y páginas tipo coincidan con el origen en estructura, jerarquía y marca.
Diferencias de píxel por fuentes/render del navegador no bloquean.
