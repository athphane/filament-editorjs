<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ListRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];

        return view('filament-editorjs::renderers.list', [
            ...$data,
        ])->render();
    }

    public function getType(): string
    {
        return 'list';
    }
}
