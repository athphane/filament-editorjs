<?php

namespace Athphane\FilamentEditorjs\Renderers;

class DelimiterRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];

        return view('filament-editorjs::renderers.delimiter', [
            ...$data,
        ])->render();
    }

    public function getType(): string
    {
        return 'delimiter';
    }
}
