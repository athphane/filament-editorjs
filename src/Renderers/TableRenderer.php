<?php

namespace Athphane\FilamentEditorjs\Renderers;

class TableRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $content = $data['content'] ?? [];

        return view('filament-editorjs::renderers.table', [
            'content' => $content,
            'config'  => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'table';
    }

    public function getWordCount(array $block): int
    {
        $rows = data_get($block, 'data.content', []);
        $text = '';
        foreach ($rows as $row) {
            foreach ($row as $cell) {
                $text .= ' ' . $cell;
            }
        }
        return str_word_count(strip_tags($text));
    }
}
