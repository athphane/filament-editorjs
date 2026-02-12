<?php

namespace Athphane\FilamentEditorjs\Tests\TestSupport\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom([
            __DIR__ . '/../database',
        ]);
    }
}
