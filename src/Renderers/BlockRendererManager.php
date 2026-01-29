<?php

namespace Athphane\FilamentEditorjs\Renderers;

class BlockRendererManager
{
    protected array $renderers = [];

    protected array $defaultConfig = [];

    public function __construct(array $defaultConfig = [])
    {
        $this->defaultConfig = $defaultConfig;
    }

    /**
     * Register a block renderer
     */
    public function addRenderer(BlockRenderer $renderer): void
    {
        $this->renderers[$renderer->getType()] = $renderer;
    }

    /**
     * Get a specific renderer by type
     */
    public function getRenderer(string $type): ?BlockRenderer
    {
        return $this->renderers[$type] ?? null;
    }

    /**
     * Render an entire EditorJS output
     *
     * @param  string|array  $content
     */
    public function renderContent($content, array $config = []): string
    {
        $data = is_string($content) ? json_decode($content, true) : $content;

        if ( ! isset($data['blocks']) || ! is_array($data['blocks'])) {
            return '';
        }

        $output = [];

        foreach ($data['blocks'] as $block) {
            $output[] = $this->renderBlock($block, $config);
        }

        // Use the wrapper template to wrap all blocks
        $wrapper = $config['wrapper_template'] ?? $this->defaultConfig['wrapper_template'] ?? 'filament-editorjs::renderers.content-wrapper';

        return view($wrapper, [
            'blocks' => $output,
            'config' => array_merge($this->defaultConfig, $config),
        ])->render();
    }

    /**
     * Render a single block
     */
    public function renderBlock(array $block, array $config = []): string
    {
        $type = $block['type'];

        $renderer = $this->getRenderer($type);

        if ( ! $renderer) {
            // Fallback to a default renderer if none exists
            $renderer = $this->getDefaultRenderer($type);
        }

        // Merge config with default config
        $blockConfig = array_merge($this->defaultConfig, $config);

        return $renderer->render($block, $blockConfig);
    }

    /**
     * Get a default renderer for unsupported block types
     */
    protected function getDefaultRenderer(string $type): BlockRenderer
    {
        return new class($this->defaultConfig) extends BlockRenderer
        {
            private string $type;

            public function __construct(array $config, string $type = 'unknown')
            {
                parent::__construct($config);
                $this->type = $type;
            }

            public function render(array $block, array $config = []): string
            {
                // For unknown blocks, just return the data as JSON (for debugging purposes)
                return '<!-- Unknown block type: ' . $this->type . ' -->';
            }

            public function getType(): string
            {
                return $this->type;
            }
        };
    }
}
