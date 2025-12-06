<?php

namespace Athphane\FilamentEditorjs\Renderers;

class CodeRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $code = $data['code'] ?? $data['message'] ?? $data['content'] ?? '';

        // Escape code content to prevent XSS
        $escapedCode = $this->escape($code);

        return view('filament-editorjs::renderers.code', [
            'code' => $escapedCode,
            'config' => $this->config
        ])->render();
    }

    public function getType(): string
    {
        return 'code';
    }
}