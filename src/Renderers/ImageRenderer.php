<?php

namespace Athphane\FilamentEditorjs\Renderers;

class ImageRenderer extends BlockRenderer
{
    public function render(array $block): string
    {
        $data = $block['data'] ?? [];
        $file = $data['file'] ?? [];
        $url = $file['url'] ?? $data['url'] ?? '';
        $caption = $data['caption'] ?? '';
        $withBorder = $data['withBorder'] ?? false;
        $withBackground = $data['withBackground'] ?? false;
        $stretched = $data['stretched'] ?? false;

        // Escape all user inputs to prevent XSS
        $url = $this->escape($url);
        $caption = $this->escape($caption);

        return view('filament-editorjs::renderers.image', [
            'url'            => $url,
            'caption'        => $caption,
            'withBorder'     => $withBorder,
            'withBackground' => $withBackground,
            'stretched'      => $stretched,
            'config'         => $this->config,
        ])->render();
    }

    public function getType(): string
    {
        return 'image';
    }
}
