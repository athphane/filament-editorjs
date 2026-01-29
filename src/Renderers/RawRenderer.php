<?php

namespace Athphane\FilamentEditorjs\Renderers;

class RawRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $html = $data['html'] ?? $data['message'] ?? $data['content'] ?? '';

        return view('filament-editorjs::renderers.raw', [
            'html'   => $html,
            'config' => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'raw';
    }
}
