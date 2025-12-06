<?php

namespace Athphane\FilamentEditorjs\Renderers;

class RawRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $html = $data['html'] ?? $data['message'] ?? $data['content'] ?? '';

        // For security, we'll escape the HTML by default
        // In a real implementation, you might want to provide an option to allow raw HTML
        $escapedHtml = $this->escape($html);

        return view('filament-editorjs::renderers.raw', [
            'html'   => $escapedHtml,
            'config' => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'raw';
    }
}
