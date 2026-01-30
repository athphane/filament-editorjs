<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ImageRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];

        return view('filament-editorjs::renderers.image', [
           ...$data
        ])->render();
    }

    public function getType(): string
    {
        return 'image';
    }
}
