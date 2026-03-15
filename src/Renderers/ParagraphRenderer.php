<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ParagraphRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $content = $data['text'] ?? '';

        return view('filament-editorjs::renderers.paragraph', [
            ...$data,
        ])->render();
    }

    public function getType(): string
    {
        return 'paragraph';
    }

    public function getWordCount(array $block): int
    {
        $text = data_get($block, 'data.text', '');
        return str_word_count(strip_tags($text));
    }
}
