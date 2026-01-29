<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ChecklistRenderer extends BlockRenderer
{
    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $items = $data['items'] ?? [];

        // Process items to capture checked status
        $processedItems = [];
        foreach ($items as $item) {
            if (is_array($item)) {
                $processedItems[] = [
                    'content' => $item['content'] ?? $item['message'] ?? $item['text'] ?? '',
                    'checked' => $item['checked'] ?? false,
                ];
            } else {
                $processedItems[] = [
                    'content' => $item,
                    'checked' => false,
                ];
            }
        }

        return view('filament-editorjs::renderers.checklist', [
            'items'  => $processedItems,
            'config' => array_merge($this->config, $config),
        ])->render();
    }

    public function getType(): string
    {
        return 'checklist';
    }
}
