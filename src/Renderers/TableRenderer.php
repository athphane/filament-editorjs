<?php

namespace Athphane\FilamentEditorjs\Renderers;

class TableRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $content = $data['content'] ?? [];

        // Process the table content to escape values
        $processedContent = [];
        foreach ($content as $row) {
            if (is_array($row)) {
                $processedContent[] = array_map([$this, 'escape'], $row);
            } else {
                $processedContent[] = [];
            }
        }

        return view('filament-editorjs::renderers.table', [
            'content' => $processedContent,
            'config'  => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'table';
    }
}
