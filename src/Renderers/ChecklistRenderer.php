<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ChecklistRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];

        return view('filament-editorjs::renderers.checklist', [
            ...$data,
        ])->render();
    }

    public function getType(): string
    {
        return 'checklist';
    }

    public function getWordCount(array $block): int
    {
        $items = data_get($block, 'data.items', []);
        $text = '';
        foreach ($items as $item) {
            $text .= ' ' . data_get($item, 'text', '');
        }

        return str_word_count(strip_tags($text));
    }
}
