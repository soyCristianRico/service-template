# DESIGN.md — Bricoteca

> **For AI agents (Claude Code, Cursor, etc.)**: This file is the visual contract for Bricoteca. When generating or modifying any view under `resources/views/pages/**` (public side) or `resources/views/components/**`, follow this file first. The admin (`pages/admin/**`) is internal and not bound by this contract — it uses Flux defaults.
>
> **Source of truth**: brand brief "Bricoteca — Sistema fundacional de marca" (in conversation). Last regenerated 2026-06-04.

## 1. Concept & positioning

- Bricoteca **es una biblioteca profesional de herramientas**: organizada, cercana y disponible — reservas la herramienta adecuada sin comprarla, sin líos y con confianza.
- **NO es**: ferretería antigua, web de catálogo pobre, startup artificial "demasiado app", marca de polígono sin diseño, corporación fría, ni marketplace genérico sin control del producto.
- Territorio: **profesionalidad industrial + facilidad digital + confianza local**. Emoción clave: control, seguridad y alivio (no aspiracional, no lujo).
- Local con ambición nacional: hoy Baix Maestrat, mañana toda España. La UI debe parecer construida para escalar.

## 2. Stack

- Laravel 12 + Livewire 4 (SFC under `resources/views/pages/`)
- Flux Pro v2 — use Flux first; drop to custom Blade only when no equivalent
- Tailwind v4 (CSS-first config via `@theme` in `resources/css/app.css`)
- Heroicons via `<flux:icon>`

## 3. Color tokens

### Palette

| Token | Hex | Role | Class usage |
|---|---|---|---|
| `--color-brand` | `#1f4e5f` | Azul petróleo — color principal de marca, superficies oscuras, navegación | `bg-brand`, `text-brand` |
| `--color-brand-foreground` | `#ffffff` | Texto sobre `brand` | `text-brand-foreground` |
| `--color-brand-muted` | `#dce8ec` | Fondos suaves de marca, chips, hovers sutiles | `bg-brand-muted` |
| `--color-accent` | `#f26a2e` | Naranja señal — CTAs, reservas, puntos de atención | `bg-accent`, `text-accent` |
| `--color-accent-foreground` | `#ffffff` | Texto sobre `accent` | `text-accent-foreground` |
| `--color-accent-soft` | `#ffe7da` | Badges naranja, fondos de realce ligeros | `bg-accent-soft` |
| `--color-success` | `#2e8b57` | Verde disponibilidad — "listo para reservar", confirmaciones | `text-success`, `bg-success` |
| `--color-success-soft` | `#e3f4ea` | Fondo de badges de disponibilidad | `bg-success-soft` |
| `--color-foreground` | `#172024` | Grafito industrial — texto fuerte | `text-foreground` |
| `--color-muted-foreground` | `#5e6a70` | Gris herramienta — texto secundario, iconos, metadatos | `text-muted-foreground` |
| `--color-background` | `#f8faf9` | Blanco taller — fondo de página | `bg-background` |
| `--color-surface` | `#ffffff` | Cards, fichas | `bg-surface` |
| `--color-surface-muted` | `#f1f4f5` | Bloques alternos, fondos de sección | `bg-surface-muted` |
| `--color-border` | `#e6eaec` | Bordes y separadores | `border-border` |
| `--color-border-strong` | `#c8d1d5` | Bordes con más contraste | `border-border-strong` |

### How to use the accent (`#f26a2e`)
- DO: CTAs ("Reservar herramienta"), badges de reserva, hover de enlaces clave, highlights, puntos de atención.
- DON'T: grandes bloques de fondo, secciones enteras naranjas, layouts dominados por el acento. El naranja es señal, no superficie.
- El **verde** (`success`) sólo para disponibilidad/confirmaciones — nunca como acento general.
- El **azul brand** es la voz dominante de superficie oscura (footer, hero sólido, nav).

### `@theme` block to paste into `resources/css/app.css`

```css
@theme {
    --color-brand: #1f4e5f;
    --color-brand-foreground: #ffffff;
    --color-brand-muted: #dce8ec;

    --color-accent: #f26a2e;
    --color-accent-foreground: #ffffff;
    --color-accent-soft: #ffe7da;

    --color-success: #2e8b57;
    --color-success-soft: #e3f4ea;

    --color-background: #f8faf9;
    --color-surface: #ffffff;
    --color-surface-muted: #f1f4f5;

    --color-foreground: #172024;
    --color-muted-foreground: #5e6a70;

    --color-border: #e6eaec;
    --color-border-strong: #c8d1d5;

    --font-sans: 'Inter', sans-serif;
    --font-display: 'Sora', sans-serif;

    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 18px;
    --radius-xl: 24px;

    --shadow-sm: 0 1px 2px rgba(23, 32, 36, 0.06);
    --shadow-md: 0 8px 24px rgba(23, 32, 36, 0.08);
    --shadow-lg: 0 18px 48px rgba(23, 32, 36, 0.12);

    --spacing-section: 96px;
    --spacing-container: 24px;
    --spacing-card: 24px;
}
```

## 4. Typography

### Font family
Dos familias, con roles estrictos:
- **Sora** (`--font-display`) → titulares, navegación, botones, elementos de interfaz. Presencia geométrica e industrial sin agresividad.
- **Inter** (`--font-sans`) → cuerpo de texto, fichas de producto, formularios, contenido largo. Máxima legibilidad.

Cargadas vía Bunny Fonts (`@import` en `resources/css/app.css`): Sora 500/600/700, Inter 400/500/600. Usar `font-display` (Sora) y `font-sans` (Inter, por defecto en `<body>`).

### Scale & weights

| Level | Use | Family | Class / inline |
|---|---|---|---|
| H1 hero | One per page max | Sora 700 | `font-display font-bold; line-height: 1.05; letter-spacing: -0.02em;` |
| H2 section | Encabezado de sección | Sora 600 | `font-display font-semibold; letter-spacing: -0.01em;` |
| H3 card | Nombre de herramienta / pack | Sora 600 | `font-display font-semibold;` |
| Subtítulo | Apoyo bajo titular | Sora 500 | `font-display font-medium;` |
| Body | Párrafos, descripciones | Inter 400 | `font-sans; line-height: 1.6;` |
| Button | CTAs | Sora 600 | `font-display font-semibold;` (sin uppercase forzado) |
| Metadata | Precio/día, zona, etiquetas | Inter 500 | `font-sans font-medium text-muted-foreground;` |

### Comportamiento
Titulares cortos, claros y funcionales — refuerzan eficiencia, no decoración. Nada de slogans vacíos.
Ejemplos válidos: "Reserva herramientas profesionales sin comprarlas.", "El kit que necesitas para terminar la obra.", "Herramientas listas para recoger o recibir en zona."

### Flux mapping
- `<flux:heading size="2xl">` → H1 (añadir `font-display`)
- `<flux:heading size="xl">` → H2
- `<flux:heading size="lg">` → H3
- `<flux:text>` → body
- `<flux:text size="sm" class="text-muted-foreground">` → metadatos

## 5. Spacing, radius & elevation

- **Spacing**: ordenado y con aire, modular tipo catálogo. Secciones `py-16 lg:py-24` (token `--spacing-section: 96px`). Contenedor con `px-6` (`--spacing-container: 24px`). Padding de card `p-6` (`--spacing-card: 24px`).
- **Radius**: medio-alto, robusto pero no juguetón. Botones y cards `rounded-lg` (`--radius-lg: 18px`); inputs `rounded-md` (12px); badges/chips `rounded-md`; contenedores grandes `rounded-xl` (24px).
- **Shadows**: suaves y técnicas, nunca dramáticas. `--shadow-sm` para bordes elevados, `--shadow-md` para cards en hover, `--shadow-lg` sólo para overlays/modales. Preferir contraste de superficie + borde sobre sombra fuerte.

## 6. Components

### Buttons
- **Primario**: `<flux:button variant="primary">` — `bg-accent text-accent-foreground`, `rounded-lg`, alto mínimo 48px (`min-h-12`), peso Sora 600. Texto directo: **Reservar herramienta**, **Consultar disponibilidad**, **Pedir por WhatsApp**.
- **Secundario**: `<flux:button variant="ghost">` — fondo claro, `border border-brand text-brand`, `rounded-lg`.
- **Tamaños**: default `size="base"`; CTAs de hero `size="lg"`.

### Inputs (buscador + lead form)
- `<flux:input>`, `<flux:select>`, `<flux:textarea>` con `border-border` (focus → `border-brand`).
- Buscador de herramienta protagonista en home: input ancho con icono lupa, CTA naranja adjunto.
- El lead form vive en `resources/views/components/⚡lead-form` — **NO reinventar**, embeber con `<livewire:lead-form />`.

### Cards (ficha de herramienta)
Deben parecer ordenadas, técnicas y fiables:
- Fondo `bg-surface`, `border border-border`, `rounded-lg`, `p-6`, hover `shadow-md`.
- Estructura: imagen limpia del producto → nombre (H3 Sora 600) → uso principal (body) → precio/día (metadato) → badge de disponibilidad → zona de entrega → CTA.
- Sensación de "balda de biblioteca": grid ordenado, etiquetas/códigos visibles.

### Badges
- Disponibilidad (positivo): `<flux:badge>` custom `bg-success-soft text-success` — "Disponible", "Listo para reservar".
- Reserva/atención: `bg-accent-soft text-accent`.
- Neutro/metadato: `<flux:badge color="zinc">`.

### Packs por tipo de obra
- Card más grande/destacada que la ficha individual: imagen + lista de herramientas incluidas + precio del pack + CTA. Refuerza la metáfora "el kit que necesitas para terminar la obra".

## 7. Layouts

### Hero
- Full-width, `min-h-[60vh]` a `[70vh]`.
- H1 (Sora 700) + subtítulo + buscador de herramienta protagonista + 1 CTA primario.
- Fondo: foto de obra ordenada / estantería de herramientas, o sólido `bg-brand` con detalles en `accent` y rejilla técnica sutil.

### Section
- `py-16 lg:py-24`.
- Contenedor `max-w-6xl mx-auto px-6`.
- Alternar `bg-background` / `bg-surface-muted` para ritmo visual de catálogo.

### Footer
- `bg-brand text-brand-foreground` (o `bg-foreground` para grafito).
- 3 columnas en desktop, 1 en móvil. Incluye zona de servicio, contacto/WhatsApp, categorías.

### Homepage — jerarquía recomendada
1. Propuesta clara (hero).
2. Buscador de herramienta.
3. Packs por tipo de obra.
4. Categorías principales (por tipo de obra).
5. Cómo funciona.
6. Herramientas destacadas.
7. Zona de servicio.
8. Confianza: entrega, revisión, soporte.
9. CTA final.

## 8. Landing pattern (`/category-city`)

El template compartido `resources/views/pages/⚡landing.blade.php` renderiza cada landing programática. Específico de Bricoteca:
- Hero con categoría + ciudad en el H1 ("Alquiler de [categoría] en [ciudad]").
- Buscador / grid de herramientas de la categoría con badges de disponibilidad y zona.
- Lead form embebido tras el primer scroll (`<livewire:lead-form :landing="$landing" />`).
- Bloque de confianza local (entrega en zona, revisión, soporte) + CTA WhatsApp.
- Breadcrumb derivado del árbol de categorías.

## 9. Imagery

### DO
- Herramientas reales, limpias, sobre fondos claros o en contexto de obra ordenada.
- Primeros planos de material profesional.
- Personas usando herramientas (reales, no stock falso).
- Estanterías organizadas de herramientas (refuerza "biblioteca").
- Vehículo / entrega local para reforzar confianza.
- Iluminación limpia tipo taller; atmósfera de servicio fiable.

### DON'T
- Fotos oscuras, caóticas o "obra sucia".
- Stock falso o personas claramente de banco de imágenes.
- Renders aislados sobre blanco puro sin contexto.
- Estética de bricolaje infantil.

### OG image (`og:image`)
- 1200×630.
- Fondo `brand` (azul petróleo), B modular del logo arriba-izquierda, claim grande centrado (Sora 700) en blanco, franja/detalle en `accent`.
- Stored in `public/images/og-default.png` (env: `SEO_DEFAULT_IMAGE`).

### Favicon / app icon
- Cuadrado redondeado, fondo azul petróleo (`brand`), **B modular** (con un módulo naranja). Marca digital seria, no ferretería.
- Isotipo only (no wordmark).
- Archivo: `public/favicon.png` (enlazado en `layouts/public.blade.php` como `icon` + `apple-touch-icon`).

## 10. Editorial tone

- Voz: directa, técnica, cercana y profesional. Transmite control y fiabilidad, no aspiración.
- Vocabulario: "reservar" sobre "comprar"; "disponible" / "listo para reservar"; "recoger o recibir en zona"; "kit" / "pack" por tipo de obra.
- Frases cortas y funcionales. Nada de slogans vacíos ni lenguaje corporativo frío.
- CTAs en imperativo cercano: "Reserva herramienta", "Consulta disponibilidad", "Pide por WhatsApp" (no "Solicite usted").

## 11. Anti-patterns

Bricoteca explícitamente **NO debe parecer**:
- Ferretería antigua.
- Web de catálogo pobre.
- Startup artificial con estética demasiado "app".
- Marca de polígono sin diseño.
- Empresa fría tipo gran corporación nacional.
- Marketplace genérico sin control real del producto.
- Naranja como superficie dominante; verde fuera de estados de disponibilidad.

## 12. Logo

- Concepto: metáfora **brico + biblioteca**. Isotipo: **B** modular formada por bloques tipo libros/herramientas en estantería; un bloque en naranja `accent` como punto de señal. Resto en grafito `foreground`.
- Estilo: geométrico, compacto, muy legible, sin exceso de detalle. Funciona en app icon, furgoneta, pegatina, web y factura.
- **DON'T**: martillos cruzados, casco de obra, iconos de ferretería, bombillas/casas/engranajes obvios, mascotas, estética de bricolaje infantil.
- Wordmark: `Bricoteca` en geométrica tipo Sora, bajo el isotipo (lockup vertical).
- Archivos: lockup completo en `public/images/logo-bricoteca.png` (usado en el header de `layouts/public.blade.php`, `h-12`); isotipo/favicon en `public/favicon.png`.

## 13. References & resources

- Brief source: "Bricoteca — Sistema fundacional de marca" (conversación, 2026-06-04).
- Inspiración: sistemas de archivo, estanterías, catálogos técnicos, señalética industrial, sistema de préstamo de biblioteca.
- Iconografía: lineal, robusta, ligeramente redondeada, grosor medio, inspirada en señalética técnica (recoger, entregar, reservar, devolver, revisar, disponibilidad, kit, zona).
