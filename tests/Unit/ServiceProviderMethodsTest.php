<?php

use Athphane\FilamentEditorjs\FilamentEditorjsServiceProvider;

it('registers package name', function () {
    $serviceProvider = new FilamentEditorjsServiceProvider(app());

    expect($serviceProvider::$name)->toBe('filament-editorjs');
});

it('registers view namespace', function () {
    $serviceProvider = new FilamentEditorjsServiceProvider(app());

    expect($serviceProvider::$viewNamespace)->toBe('filament-editorjs');
});

it('registers renderer manager on package registered', function () {
    $app = app();

    $serviceProvider = new FilamentEditorjsServiceProvider($app);

    $serviceProvider->packageRegistered();

    expect($app->bound('filament-editorjs-renderer'))->toBeTrue();
});

it('registers default renderers on package registered', function () {
    $app = app();

    $serviceProvider = new FilamentEditorjsServiceProvider($app);

    $serviceProvider->packageRegistered();

    $manager = $app->make('filament-editorjs-renderer');

    $renderers = $manager->getRenderer('header');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('header');

    $renderers = $manager->getRenderer('paragraph');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('paragraph');

    $renderers = $manager->getRenderer('image');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('image');

    $renderers = $manager->getRenderer('list');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('list');

    $renderers = $manager->getRenderer('quote');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('quote');

    $renderers = $manager->getRenderer('code');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('code');

    $renderers = $manager->getRenderer('table');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('table');

    $renderers = $manager->getRenderer('delimiter');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('delimiter');

    $renderers = $manager->getRenderer('raw');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('raw');

    $renderers = $manager->getRenderer('inline-code');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('inline-code');

    $renderers = $manager->getRenderer('checklist');
    expect($renderers)->not->toBeNull();
    expect($renderers->getType())->toBe('checklist');
});

it('returns asset package name', function () {
    $serviceProvider = new FilamentEditorjsServiceProvider(app());

    $packageName = $serviceProvider->getAssetPackageName();

    expect($packageName)->toBe('athphane/filament-editorjs');
});

it('has correct asset package name type', function () {
    $serviceProvider = new FilamentEditorjsServiceProvider(app());

    $packageName = $serviceProvider->getAssetPackageName();

    expect($packageName)->toBeString();
});
