<?php

namespace Athphane\FilamentEditorjs\Renderers;

class DelimiterRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        return view('filament-editorjs::renderers.delimiter', [
            'config' => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'delimiter';
    }
}
