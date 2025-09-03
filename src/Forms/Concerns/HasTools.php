<?php

namespace Athphane\FilamentEditorjs\Forms\Concerns;

trait HasTools
{
    protected array $tools = [];

    /**
     * Set the default tools for the editorjs field.
     * This will use the default profile from the config.
     *
     * @return $this
     */
    public function setDefaultTools(): static
    {
        return $this->tools(config('filament-editorjs.default_profile'));
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
}
