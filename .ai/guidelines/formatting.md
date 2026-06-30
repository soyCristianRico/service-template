# Formatting

- Run `composer run format` before completing any task (Rector + Pint)
- Add imports manually, the formatter organizes them automatically
- Fallback: `vendor/bin/pint`

## Language
- **Code**: comments, documentation, commit messages, variable names, function names, class names → English
- **User-visible text**: labels, titles, buttons, placeholders, error messages, toasts, enum labels → Spanish
- This includes Blade templates, Livewire components, and any text shown in the UI
- Enum `label()` methods should return Spanish text (e.g., "Borrador" not "Draft")
