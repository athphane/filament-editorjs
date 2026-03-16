<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ListRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];

        return view('filament-editorjs::renderers.list', [
            ...$data,
        ])->render();
    }

    public function getType(): string
    {
        return 'list';
    }

    public function getWordCount(array $block): int
    {
        $items = data_get($block, 'data.items', []);
        $text = '';
        foreach ($items as $item) {
            $text .= ' ' . $item;
        }

        return str_word_count(strip_tags($text));
    }
}
