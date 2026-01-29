<?php

namespace Athphane\FilamentEditorjs\Renderers;

class QuoteRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $content = $data['message'] ?? $data['content'] ?? $data['text'] ?? '';
        $caption = $data['caption'] ?? '';
        $alignment = $data['alignment'] ?? 'left';

        return view('filament-editorjs::renderers.quote', [
            'content'   => $content,
            'caption'   => $caption,
            'alignment' => $alignment,
            'config'    => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'quote';
    }
}
