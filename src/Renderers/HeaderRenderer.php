<?php

namespace Athphane\FilamentEditorjs\Renderers;

class HeaderRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $level = $data['level'] ?? 1;
        $text = $data['message'] ?? $data['content'] ?? '';

        // Sanitize the level to prevent invalid HTML
        $level = max(1, min(6, $level));

        // Escape the text to prevent XSS
        $escapedText = $this->escape($text);

        return view('filament-editorjs::renderers.header', [
            'level'  => $level,
            'text'   => $escapedText,
            'config' => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'header';
    }
}
