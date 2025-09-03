<?php

use Athphane\FilamentEditorjs\FilamentEditorjsServiceProvider;

it('has correct package name', function () {
    $serviceProvider = new FilamentEditorjsServiceProvider(app());

    $name = $serviceProvider::$name;

    expect($name)->toBe('filament-editorjs');
});

it('has correct view namespace', function () {
    $serviceProvider = new FilamentEditorjsServiceProvider(app());

    $viewNamespace = $serviceProvider::$viewNamespace;

    expect($viewNamespace)->toBe('filament-editorjs');
});
