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
}
