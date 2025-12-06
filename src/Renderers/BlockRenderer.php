<?php

namespace Athphane\FilamentEditorjs\Renderers;

abstract class BlockRenderer
{
    protected array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * Render the block content
     *
     * @param  array  $block  The block data from EditorJS
     * @return string The rendered HTML
     */
    abstract public function render(array $block): string;

    /**
     * Get the block type this renderer handles
     */
    abstract public function getType(): string;

    /**
     * Get configuration value
     */
    protected function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * Escape HTML content to prevent XSS
     */
    protected function escape(string $content): string
    {
        return htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    }
}
