<?php

namespace Athphane\FilamentEditorjs;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentEditorjsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-editorjs';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament('filament-editorjs');

        return $plugin;
    }

    public function register(Panel $panel): void
    {
        // Registration logic if needed
    }

    public function boot(Panel $panel): void
    {
        // Booting logic if needed
    }
}
