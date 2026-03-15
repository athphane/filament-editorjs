<?php

namespace Athphane\FilamentEditorjs\Infolists\Components;

use Filament\Infolists\Components\Entry;

class EditorjsEntry extends Entry
{
    protected string $view = 'filament-editorjs::infolists.components.editorjs-entry';

    protected array $renderConfig = [];

    public function renderConfig(array $config): static
    {
        $this->renderConfig = $config;

        return $this;
    }

    public function getRenderConfig(): array
    {
        return $this->renderConfig;
    }
}
