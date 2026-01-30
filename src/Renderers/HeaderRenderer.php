<?php

namespace Athphane\FilamentEditorjs\Renderers;

class HeaderRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $level = $data['level'] ?? 1;
        $text = $data['message'] ?? $data['content'] ?? $data['text'] ?? '';

        // Sanitize the level to prevent invalid HTML
        $level = max(1, min(6, $level));

        return view('filament-editorjs::renderers.header', [
            'level'  => $level,
            'text'   => $text,
        ])->render();
    }

    public function getType(): string
    {
        return 'header';
    }
}
