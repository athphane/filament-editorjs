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
}
