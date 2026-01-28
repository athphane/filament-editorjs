<?php

namespace Athphane\FilamentEditorjs\Forms\Concerns;

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
        return $this->tools(config('filament-editorjs.default_profile', 'default'));
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
        $profile = (array) config("filament-editorjs.profiles.{$tool_profile}", []);

        $this->tools = [];

        foreach ($profile as $key => $value) {
            if (is_int($key)) {
                $this->tools[$value] = [];
            } else {
                $this->tools[$key] = $value;
            }
        }

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
     * @param  array  $config  Configuration for the tool
     */
    public function addPlugin(string $key, array $config = []): static
    {
        // 1. Add the tool config
        $this->tools[$key] = $config;

        return $this;
    }

    public function getPluginUrls(): array
    {
        return array_filter($this->pluginUrls);
    }
}
