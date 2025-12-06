<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ChecklistRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $items = $data['items'] ?? [];

        // Process items to escape content and capture checked status
        $processedItems = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $processedItems[] = [
                    'content' => $this->escape($item['content'] ?? $item['message'] ?? $item['text'] ?? ''),
                    'checked' => $item['checked'] ?? false,
                ];
            } else {
                $processedItems[] = [
                    'content' => $this->escape($item),
                    'checked' => false,
                ];
            }
        }

        return view('filament-editorjs::renderers.checklist', [
            'items' => $processedItems,
            'config' => $this->config
        ])->render();
    }

    public function getType(): string
    {
        return 'checklist';
    }
}