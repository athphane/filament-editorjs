<?php

namespace Athphane\FilamentEditorjs\Renderers;

class QuoteRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];

        return view('filament-editorjs::renderers.quote', [
            ...$data
        ])->render();
    }

    public function getType(): string
    {
        return 'quote';
    }
}
