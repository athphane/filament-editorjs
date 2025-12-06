<?php

namespace Athphane\FilamentEditorjs;

use Athphane\FilamentEditorjs\Renderers\BlockRenderer;

class FilamentEditorjs
{
    /**
     * Render EditorJS content for display
     *
     * @param  string|array  $content
     */
    public static function renderContent($content, array $config = []): string
    {
        $manager = app('filament-editorjs-renderer');

        return $manager->renderContent($content, $config);
    }

    /**
     * Add a custom renderer globally
     */
    public static function addRenderer(BlockRenderer $renderer): void
    {
        app('filament-editorjs-renderer')->addRenderer($renderer);
    }

    /**
     * Add multiple custom renderers globally
     */
    public static function addRenderers(array $renderers): void
    {
        $manager = app('filament-editorjs-renderer');
        foreach ($renderers as $renderer) {
            if ($renderer instanceof BlockRenderer) {
                $manager->addRenderer($renderer);
            }
        }
    }
}
