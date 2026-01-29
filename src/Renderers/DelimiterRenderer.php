<?php

namespace Athphane\FilamentEditorjs\Renderers;

class DelimiterRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        return view('filament-editorjs::renderers.delimiter', [
            'config' => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'delimiter';
    }
}
