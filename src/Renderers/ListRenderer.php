<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ListRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $style = $data['style'] ?? 'unordered'; // Can be 'ordered' or 'unordered'
        $items = $data['items'] ?? [];

        return view('filament-editorjs::renderers.list', [
            'items'  => $items,
            'style'  => $style,
            'config' => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'list';
    }
}
