<?php

namespace Athphane\FilamentEditorjs\Renderers;

class QuoteRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];

        return view('filament-editorjs::renderers.quote', [
            ...$data,
        ])->render();
    }

    public function getType(): string
    {
        return 'quote';
    }

    public function getWordCount(array $block): int
    {
        $text = data_get($block, 'data.text', '');
        $caption = data_get($block, 'data.caption', '');
        if ($caption) {
            $text .= ' ' . $caption;
        }
        return str_word_count(strip_tags($text));
    }
}
