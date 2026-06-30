---
name: design-system-from-brief
description: Transform a brand direction brief (text, references, or both) into a structured DESIGN.md at the project root, plus optionally update the Tailwind @theme block in resources/css/app.css. Use when the user asks to create, generate or write a design system, a DESIGN.md, or to "turn this brand brief into a design contract". The brief is typically a markdown document with positioning, colors, typography and tone, but image references and competitor URLs are also accepted.
---

# Design system from brief

Generate a `DESIGN.md` at the project root that acts as the visual contract every future "implement this view" prompt reads first. The input is a brand direction document (color palette, typography, positioning, photography direction, anti-patterns). The output is a structured Markdown file specifically wired to the project's actual stack — for rental-template clones that means Laravel 12 + Livewire 4 + Flux Pro 2 + Tailwind 4.

## When to invoke

Trigger this skill when the user says any of:
- "Genera el DESIGN.md desde este brief"
- "Crea el sistema de diseño con esto"
- "Te paso la dirección de marca, hazme el design.md"
- "Convierte este brief en design contract"
- Equivalent in English

Skip the skill (don't invoke) when:
- The user just wants to tweak colors in `app.css` directly
- There's no brief yet — in that case help them write one first (see §1)
- A `DESIGN.md` already exists and is current — propose updating it rather than overwriting blindly

## Inputs accepted

1. **Markdown brief** — pasted in the conversation. The most common input. Should contain at least: positioning concept, color palette with hex codes, typography, tone.
2. **Image references** — screenshots, mood boards, logos. Read them multimodally and extract patterns.
3. **Competitor URLs** — use WebFetch to pull the page, then describe the visual language.
4. **Mix of the above** — common when the user has a brief AND a screenshot they like.

If only 1 is provided, that's enough. If the brief is missing critical fields (no color palette, no typography), ask before generating — don't invent core brand decisions.

## Process

### Phase 1 — Confirm the project context

Before writing anything, verify the project the DESIGN.md will live in:

```bash
ls CLAUDE.md composer.json
```

- If `composer.json` mentions `livewire/flux-pro` → it's a rental-template clone or ruklab itself → use the Flux Pro + Tailwind 4 mapping.
- If neither → ask the user what stack the project is on before assuming.

Also check if a `DESIGN.md` already exists. If yes, ask whether to overwrite or merge.

### Phase 2 — Parse the brief

Extract these atoms from the input (any source):

| Atom | Looks like | Goes into DESIGN.md section |
|---|---|---|
| **Concept / positioning** | "Modern industrial premium, not affiliation, not low-cost" | §1 Concept |
| **Colors** | Hex codes + role (accent, primary, neutrals, semantic) | §3 Color tokens |
| **Typography** | Font family + weights + scale + tracking/letter-spacing | §4 Typography |
| **Spacing / radius** | "Mucho aire", "spacing generoso" | §5 Spacing & radius |
| **Components** | "CTAs amarillos", "cards con poco borde" | §6 Components |
| **Layout** | "Hero protagonista", "secciones full-width" | §7 Layouts |
| **Photography** | "Ciudad nocturna, técnicos, no stock" | §9 Imagery |
| **Tone** | "Premium pero accesible" | §10 Editorial tone |
| **Anti-patterns** | "NO obra barata, NO rayos en el logo" | §11 Anti-patterns |

When the brief uses a CSS variable block (like `@theme { --color-accent: #F5C400; }`), preserve those exact tokens. They become the source of truth for both DESIGN.md and `resources/css/app.css`.

### Phase 3 — Map to the stack

For rental-template clones, every visual decision must map to a Flux Pro component or a Tailwind utility. Add a "Flux mapping" sub-section under each component category:

- Buttons → `<flux:button variant="primary|ghost|danger" />` with `accent` semantic class
- Inputs → `<flux:input>`, `<flux:select>`, `<flux:textarea>`
- Cards → custom Blade component referencing `--color-surface` + `--color-primary-dark`
- Headings → `<flux:heading size="...">` + brief-defined `font-weight` and `letter-spacing`
- Form (lead capture) → references `resources/views/components/⚡lead-form`

When the brief calls for something Flux doesn't ship (e.g. a custom Hero block), document it as "custom Blade component, no Flux equivalent" and propose a name (`<x-marketing.hero>`, etc.).

### Phase 4 — Write DESIGN.md

Use the structure below verbatim — every section is required, even if short. Empty sections invite drift; a one-liner ("no decisions yet, default to Flux") is better than missing.

```markdown
# DESIGN.md — <Project name>

> **For AI agents (Claude Code, Cursor, etc.)**: This file is the visual contract for <project>. When generating or modifying any view under `resources/views/pages/**` (public side) or `resources/views/components/**`, follow this file first. The admin (`pages/admin/**`) is internal and not bound by this contract — it uses Flux defaults.
>
> **Source of truth**: brief at `<path-or-link-or-"in-repo">`. Last regenerated <date>.

## 1. Concept & positioning

- One sentence on what the site IS.
- One sentence on what it's NOT (3-5 negatives — "no affiliation, no low-cost, no SEO spam").

## 2. Stack

- Laravel 12 + Livewire 4 (SFC under `resources/views/pages/`)
- Flux Pro v2 — use Flux first; drop to custom Blade only when no equivalent
- Tailwind v4 (CSS-first config via `@theme` in `resources/css/app.css`)
- Heroicons via `<flux:icon>`

## 3. Color tokens

### Palette

| Token | Hex | Role | Class usage |
|---|---|---|---|
| `--color-accent` | `#XXXXXX` | <role> | `bg-accent`, `text-accent` |
| `--color-accent-content` | `#XXXXXX` | hover, links, badges (slightly darker accent) | `text-accent-content` |
| `--color-accent-foreground` | `#XXXXXX` | text ON accent backgrounds | `text-accent-foreground` |
| `--color-primary-dark` | `#XXXXXX` | brand dark — main text + dark surfaces | `bg-primary-dark`, `text-primary-dark` |
| `--color-secondary-gray` | `#XXXXXX` | secondary text, meta | `text-secondary-gray` |
| `--color-surface` | `#XXXXXX` | cards, subtle bg | `bg-surface` |
| `--color-background` | `#XXXXXX` | page bg | `bg-background` |

### How to use the accent
- DO: CTAs, hover states, key links, badges, highlights
- DON'T: large background blocks, full sections, layouts dominated by the accent

### `@theme` block to paste into `resources/css/app.css`

```css
@theme {
    --color-accent: #XXXXXX;
    /* ... full block from §3 above ... */
}
```

## 4. Typography

### Font family
`<family-name>` via <load method — Bunny Fonts, Google Fonts, self-hosted>. Single family unless explicitly justified.

### Scale & weights

| Level | Use | Class / inline |
|---|---|---|
| H1 hero | One per page max | `font-weight: 700; line-height: 0.95; letter-spacing: -0.03em;` |
| H2 section | | `font-weight: 600; letter-spacing: -0.02em;` |
| H3 card | | `font-weight: 600;` |
| Body | | `font-weight: 400; line-height: 1.6;` |
| Button | | `font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase;` (only if brief says so) |

### Flux mapping
- `<flux:heading size="2xl">` for H1
- `<flux:heading size="xl">` for H2
- `<flux:heading size="lg">` for H3
- `<flux:text>` for body

## 5. Spacing, radius & elevation

- Spacing scale: <"generous" / "dense" / specific Tailwind tokens used>
- Radius: `rounded-<size>` for <components>
- Shadows: <list of shadow utilities used, or "no shadows — flat design">

## 6. Components

### Buttons
- Primary: `<flux:button variant="primary">` — uses `bg-accent text-accent-foreground`
- Secondary: `<flux:button variant="ghost">` — `border-primary-dark text-primary-dark`
- Sizes: default `size="base"`; CTAs in hero use `size="lg"`

### Inputs (lead form)
- `<flux:input>` with `text-primary-dark` border `border-secondary-gray/30`
- Lead form lives in `resources/views/components/⚡lead-form` — DON'T re-invent

### Cards
- Background: `bg-background` or `bg-surface` depending on contrast needed
- Padding: `p-6` or `p-8` (brief-driven)
- Border: <"none, rely on bg contrast" / "border border-secondary-gray/20">

### Badges
- `<flux:badge>` with `color="zinc"` for neutral, accent custom class for highlights

## 7. Layouts

### Hero
- Full-width, `min-h-[60vh]` to `[80vh]`
- H1 + subtitle + 1 primary CTA + 0-1 secondary CTA
- Background: <photo-driven or solid `bg-primary-dark` with accent details>

### Section
- `py-16 lg:py-24`
- Container `max-w-6xl mx-auto px-6`

### Footer
- `bg-primary-dark text-background`
- 3 columns desktop, 1 mobile

## 8. Landing pattern (`/category-city`)

The shared template `resources/views/pages/⚡landing.blade.php` renders every programmatic landing. Specific to this brand:
- Hero with category + city in H1
- Lead form embedded after the first scroll (`<livewire:lead-form :landing="$landing" />`)
- <"Show product grid" / "No product grid — copy + form only"> (decided per brief)
- Breadcrumb derived from the category tree

## 9. Imagery

### DO
- <list from brief — "city at night, technicians, real installations, infrastructure crítica">

### DON'T
- <list from brief — "no stock, no isolated white-bg renders, no fake people">

### OG image (`og:image`)
- 1200×630
- <description of layout — "dark bg, logo top-left, claim large center, accent stripe">
- Stored in `public/images/og-default.jpg` (env: `SEO_DEFAULT_IMAGE`)

### Favicon
- Isotype only (no wordmark) — sizes 32×32, 192×192, 512×512
- Stored in `public/favicon.png`

## 10. Editorial tone

- Voice: <"directo y técnico" / "cercano y profesional" / etc.>
- Vocabulary: prefer <X> over <Y>
- Sentence length: <short / mid>
- CTAs use verbs in imperative ("Pide presupuesto", not "Solicite usted").

## 11. Anti-patterns

What this site explicitly is NOT:
- <list from brief — "afiliación, directorio, SEO spam, low-cost industrial">

## 12. Logo

- Concept: <"minimalist geometric monogram" / etc.>
- DON'T use literal industry icons (rayos, enchufes, generators drawn) — those age badly
- Monogram: <"AG" / etc.>, geometric, scalable
- Wordmark: `<NAME>` separated from the isotype

## 13. References & resources

- Brief source: <link/path>
- Inspiration sites: <list from brief — "Stripe, Linear, Vercel pero industrializadas">
- Brand color console: <link to a generated palette page if any>
```

### Phase 5 — Optional `app.css` update

After writing DESIGN.md, ask:

> "¿Aplico también el bloque `@theme` a `resources/css/app.css` para que las clases (`bg-accent`, `text-primary-dark`, etc.) funcionen ya? Sin esto, las clases del DESIGN.md son sólo documentación."

If yes:
1. Read `resources/css/app.css`
2. Replace the existing `@theme { ... }` block (or add one if missing) with the brief's CSS variables
3. Preserve any imports above (`@import 'tailwindcss';`, `@import '...flux.css';`)
4. Run `npm run build` (or tell the user to) to verify it compiles

### Phase 6 — Verify

After writing the file:
- Show the user the file path
- Surface the 3-5 most important decisions in a short summary (don't dump the whole file)
- Suggest: "Next: open `resources/views/pages/⚡home.blade.php` and ask me to rebuild the hero following this DESIGN.md"

## Output conventions

- Write to `<project-root>/DESIGN.md` (overwrite if user confirmed earlier)
- Use the project name (from `composer.json` or `APP_NAME` in `.env`) in the title
- Date in the header (today's date, ISO format)
- Spanish content for the actual brand decisions (since rental sites are ES); English for the agent-facing scaffolding comments
- Hex colors in lowercase (`#f5c400` not `#F5C400`) — matches Tailwind convention

## What NOT to do

- **Don't invent palette decisions.** If the brief gives `#F5C400`, use `#f5c400`. Don't expand to "and a complementary purple". Stick to what's documented.
- **Don't write code samples that aren't valid for the stack.** No `border-radius: 4px` when Tailwind 4 expects `rounded-sm`.
- **Don't include the entire ruklab DESIGN.md.** That's for an internal app (workspace density, no hero). Marketing/public sites have different rules.
- **Don't over-document the admin.** The skill produces a design contract for PUBLIC views. The admin uses Flux defaults — mention it once in §2 and move on.
- **Don't dump rationale into the file.** Keep DESIGN.md operational: "use this, don't use that". Rationale lives in commit messages and PR descriptions.

## Example of a good outcome

Input: the brand brief Cristian pasted for alquilageneradores.com (yellow `#F5C400` + graphite `#1F1F1F`, Archivo, premium industrial, no obra barata).

Output: `DESIGN.md` at the project root with:
- §1 one-liner: "Operador nacional de soluciones energéticas temporales. NO afiliación, NO directorio, NO low-cost industrial."
- §3 with the 7-token palette + the exact `@theme` block to paste
- §4 Archivo with the 5 weights + the specific letter-spacings from the brief
- §9 photography list with the 6 "DO" types and 3 "DON'T" types from the brief
- §11 anti-patterns lifted verbatim from the brief's "NO parecer" section

Then app.css updated, then a one-line summary: "DESIGN.md created with 7 color tokens, Archivo as primary font, premium industrial tone. Want me to rebuild ⚡home.blade.php with this now?"
