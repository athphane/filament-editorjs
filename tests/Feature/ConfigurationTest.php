<?php

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;

it('verifies default configuration', function () {
    // Test that the default configuration is loaded correctly
    $field = EditorjsTextField::make('content');

    // Should have default tools loaded from config
    expect($field->getTools())->toBeArray();

    // Should have default min height
    expect($field->getMinHeight())->toBe(20);
});

it('verifies tool profiles from config', function () {
    // Test that the default profile contains expected tools
    $defaultField = EditorjsTextField::make('content')
        ->tools('default');

    $defaultTools = array_keys($defaultField->getTools());
    expect($defaultTools)->toContain('header');
    expect($defaultTools)->toContain('image');
    expect($defaultTools)->toContain('delimiter');
    expect($defaultTools)->toContain('list');
    expect($defaultTools)->toContain('underline');
    expect($defaultTools)->toContain('quote');
    expect($defaultTools)->toContain('table');

    // Test that the pro profile contains additional tools
    $proField = EditorjsTextField::make('content')
        ->tools('pro');

    $proTools = array_keys($proField->getTools());
    expect($proTools)->toContain('raw');
    expect($proTools)->toContain('code');
    expect($proTools)->toContain('inline-code');
    expect($proTools)->toContain('style');
});
