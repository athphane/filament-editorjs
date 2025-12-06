<?php

namespace Athphane\FilamentEditorjs\Renderers;

class QuoteRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $content = $data['message'] ?? $data['content'] ?? '';
        $caption = $data['caption'] ?? '';
        $alignment = $data['alignment'] ?? 'left';

        // Escape content to prevent XSS
        $escapedContent = $this->escape($content);
        $escapedCaption = $this->escape($caption);

        return view('filament-editorjs::renderers.quote', [
            'content' => $escapedContent,
            'caption' => $escapedCaption,
            'alignment' => $alignment,
            'config' => $this->config
        ])->render();
    }

    public function getType(): string
    {
        return 'quote';
    }
}