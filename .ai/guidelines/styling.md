# Styling

## Public headings (type scale)

- Public page/section headings use `<flux:heading level="1|2|3">` with NO size or
  `text-*`/`font-*` classes. The brand type scale lives in ONE place:
  `resources/css/app.css`, scoped to the public site.
- Level mapping: `1` = page/hero title (one `<h1>` per page), `2` = section title,
  `3` = card / sub-item title.
- Why it works: `flux:heading` with a `level` renders a semantic
  `<h1|h2|h3 data-flux-heading>` but applies `text-sm`/`font-medium` by default.
  The rules in `app.css` (`[data-public-site] h1[data-flux-heading]`, …) beat
  those by specificity and are UNLAYERED, so no `!important` is needed.
- Scope: the `data-public-site` attribute is on the public layout `<body>`. The
  admin uses another layout and keeps Flux's compact heading defaults.
- A `flux:heading` with `size` but no `level` renders a `<div data-flux-heading>`
  and is NOT restyled — use `size=` for form/modal/banner headings that should
  stay compact.
- To change a heading size, edit `app.css` (single source of truth). NEVER add
  per-heading `text-*!`/`font-*!` utilities.
