## Create Infolist Component for EditorJS component.

---

Here is what I did in a different project cause I needed to see the content in the infolist view.

```php
Section::make('Content')
->heading('Content')
->columnSpan(2)
->schema([
    ViewEntry::make('content')
        ->columnSpanFull()
        ->view('filament.infolists.components.editorjs-content'),
]),
```

And then the blade file was just a simple one that rendered the content.

```bladehtml
<div>
    {!! \Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField::renderContent($getState()) !!}
</div>
```

I want you to go ahead and make a proper component that I can use across projects that achieves the same thing.

## Reading Time Calculation.

---

✅ COMPLETED

Reading time calculation is now implemented with a clean architecture:

**Usage:**

```php
FilamentEditorjs::readingTime($content)
FilamentEditorjs::countWords($content)
```

**How it works:**

- Each `BlockRenderer` class implements `getWordCount()` method
- Built-in renderers: Paragraph, Header, List, Checklist, Quote, Code, Table
- Custom blocks define their own word count by extending `BlockRenderer`
- Configuration: `config('filament-editorjs.reading_time.words_per_minute')` (default: 225)

## Custom Blocks

---

Custom blocks are fully supported. When creating a custom block renderer:

1. Extend `BlockRenderer` class
2. Implement `render()` and `getType()` methods
3. Implement `getWordCount()` to define how to count words for your block

No config callbacks needed - the renderer class itself contains all the logic.
