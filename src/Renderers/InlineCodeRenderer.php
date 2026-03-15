<?php

namespace Athphane\FilamentEditorjs\Renderers;

class InlineCodeRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $code = $data['code'] ?? $data['message'] ?? $data['content'] ?? '';

        // Escape the code content to prevent XSS
        $escapedCode = $this->escape($code);

        return view('filament-editorjs::renderers.inline-code', [
            'code'   => $escapedCode,
            'config' => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'inline-code';
    }

    public function getWordCount(array $block): int
    {
        $text = data_get($block, 'data.code', '');
        return str_word_count(strip_tags($text));
    }
}
