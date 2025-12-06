<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ListRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $style = $data['style'] ?? 'unordered'; // Can be 'ordered' or 'unordered'
        $items = $data['items'] ?? [];

        // Escape each list item to prevent XSS
        $escapedItems = array_map([$this, 'escape'], $items);

        return view('filament-editorjs::renderers.list', [
            'items' => $escapedItems,
            'style' => $style,
            'config' => $this->config
        ])->render();
    }

    public function getType(): string
    {
        return 'list';
    }
}