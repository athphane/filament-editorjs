<?php

use Athphane\FilamentEditorjs\FilamentEditorjsPlugin;
use Filament\Contracts\Plugin;
use Filament\Panel;

it('has correct plugin id', function () {
    $plugin = new FilamentEditorjsPlugin();

    expect($plugin->getId())->toBe('filament-editorjs');
});

it('can make a new instance', function () {
    $plugin = FilamentEditorjsPlugin::make();

    expect($plugin)->toBeInstanceOf(FilamentEditorjsPlugin::class);
});

it('can get plugin instance', function () {
    $plugin = FilamentEditorjsPlugin::get();

    expect($plugin)->toBeInstanceOf(FilamentEditorjsPlugin::class);
})->skip('Plugin retrieval requires registration');

it('implements plugin interface', function () {
    $plugin = new FilamentEditorjsPlugin();

    expect($plugin)->toBeInstanceOf(Plugin::class);
});

it('can register panel', function () {
    $plugin = new FilamentEditorjsPlugin();
    $panel = app(Panel::class);

    expect(function () use ($plugin, $panel) {
        $plugin->register($panel);
    })->not->toThrow(Exception::class);
});
