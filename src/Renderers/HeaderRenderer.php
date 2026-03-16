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

    public function getWordCount(array $block): int
    {
        $text = data_get($block, 'data.message', '')
            ?: data_get($block, 'data.content', '')
            ?: data_get($block, 'data.text', '');

        return str_word_count(strip_tags($text));
    }
}
