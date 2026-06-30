# JavaScript & Alpine

## Alpine Component Structure

```javascript
Alpine.data('componentName', (serverData) => ({
    // Data (from server)
    items: serverData || [],

    // State (client-side)
    chart: null,
    isOpen: false,
    filter: Alpine.$persist('all').as('component-filter'),

    // Getters
    get filteredItems() { ... },

    // Lifecycle
    init() { ... },
    destroy() { ... },

    // Public: Actions
    toggle(id) { ... },

    // Public: Formatters
    formatNumber(val) { ... },

    // Private
    _initChart() { ... },
    _bindEvents() { ... },
}));
```

Section order: Data → State → Getters → Lifecycle → Public Actions → Public Formatters → Private (`_` prefix).

## Non-Reactive Data

Store library instances outside Alpine's reactive data to avoid proxy issues:

```javascript
Alpine.data('component', () => {
    let editorInstance = null;
    return {
        init() { editorInstance = this.$refs.editor.getEditor(); },
    };
});
```

## Flux Editor Auto-Save Pattern

Use Alpine with `$wire` instead of `wire:model` for `flux:editor` with debounced saving. Use `:value="$form->body"` on the component. Listen to `flux:editor:ready`, store the editor instance outside reactive data, and debounce `$wire.saveBody(html)` on editor `update` events.

## Optimistic UI Pattern

Update UI immediately, rollback on failure:

```javascript
async saveItem() {
    const original = this.item.text;
    this.item.text = newText;
    const success = await $wire.save(newText);
    if (!success) {
        this.item.text = original;
        Flux.toast({ text: 'Error message', variant: 'warning' });
    }
}
```

## Component Communication
- Dispatch: `window.dispatchEvent(new CustomEvent('event-name', { detail: { data } }))`
- Listen: `window.addEventListener('event-name', (e) => { ... })`
- Use `$watch()` to react to state changes

## External JS Modules
- Place in `resources/js/`, import in `app.js`
- Use `_method()` for protected methods (not `#method` - causes context issues)
- Export public API via `window` for Alpine access

## Selectors
- Use `data-` attributes for JS hooks, not classes
- Extract repeated selectors to constants
