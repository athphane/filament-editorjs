<?php

namespace Athphane\FilamentEditorjs\Renderers;

class CodeRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $code = $data['code'] ?? $data['message'] ?? $data['content'] ?? '';

        // Escape code content to prevent XSS
        $escapedCode = $this->escape($code);

        return view('filament-editorjs::renderers.code', [
            'code'   => $escapedCode,
            'config' => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'code';
    }
}
