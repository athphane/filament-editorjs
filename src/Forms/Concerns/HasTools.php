<?php

namespace Athphane\FilamentEditorjs\Forms\Concerns;

use Filament\Support\Facades\FilamentAsset;

trait HasTools
{
    protected array $tools = [];

    protected array $pluginUrls = [];

    /**
     * Set the default tools for the editorjs field.
     * This will use the default profile from the config.
     *
     * @return $this
     */
    public function setDefaultTools(): static
    {
        // Transform the config array of strings into an associative array with empty config
        $defaults = config('filament-editorjs.profiles.' . config('filament-editorjs.default_profile'));

        $this->tools = []; // Reset

        foreach ($defaults as $tool) {
            $this->tools[$tool] = []; // No specific config by default
        }

        return $this;
    }

    /**
     * Add a custom tool with optional configuration.
     *
     * @param  string  $key  The key used in window.filamentEditorJsTools
     * @param  array  $config  Configuration array to pass to the JS tool
     */
    public function addTool(string $key, array $config = []): static
    {
        $this->tools[$key] = $config;

        return $this;
    }

    /**
     * Set the tools for the editorjs field to default.
     *
     * @return $this
     */
    public function defaultTools(): static
    {
        return $this->tools('default');
    }

    /**
     * Set the tools for the editorjs field to pro.
     *
     * @return $this
     */
    public function proTools(): static
    {
        return $this->tools('pro');
    }

    /**
     * Set the tools for the editorjs field.
     *
     * @return $this
     */
    public function tools(string $tool_profile): static
    {
        $this->tools = config('filament-editorjs.profiles.' . $tool_profile);

        return $this;
    }

    /**
     * Get the tools for the editorjs field.
     */
    public function getTools(): array
    {
        return $this->tools;
    }

    /**
     * Register a custom plugin by its Filament Asset ID.
     *
     * @param  string  $key  The tool key (e.g., 'highlight')
     * @param  string  $assetId  The asset name registered in AppServiceProvider
     * @param  array  $config  Configuration for the tool
     */
    public function addPlugin(string $key, string $assetId, array $config = []): static
    {
        // 1. Add the tool config
        $this->tools[$key] = $config;

        // 2. Resolve the asset URL
        // We defer this so it happens at render time, ensuring assets are registered
        $this->pluginUrls[] = FilamentAsset::getScriptSrc($assetId);

        return $this;
    }

    public function getPluginUrls(): array
    {
        return array_filter($this->pluginUrls);
    }
}
