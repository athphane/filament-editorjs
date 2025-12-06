<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ParagraphRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $content = $data['text'] ?? '';

        return view('filament-editorjs::renderers.paragraph', [
            'content' => $content,
            'config' => $this->config
        ])->render();
    }

    public function getType(): string
    {
        return 'paragraph';
    }
}
