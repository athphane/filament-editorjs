<?php

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;

it('can instantiate editorjs text field', function () {
    $field = EditorjsTextField::make('content');

    expect($field)->toBeInstanceOf(EditorjsTextField::class);
    expect($field->getName())->toBe('content');
});

it('can set tools for editorjs field', function () {
    $field = EditorjsTextField::make('content')
        ->tools('default');

    expect($field->getTools())->toBeArray();
});

it('can set pro tools for editorjs field', function () {
    $field = EditorjsTextField::make('content')
        ->proTools();

    expect($field->getTools())->toBeArray();
});

it('can set default tools for editorjs field', function () {
    $field = EditorjsTextField::make('content')
        ->setDefaultTools();

    expect($field->getTools())->toBeArray();
});

it('can set min height for editorjs field', function () {
    $field = EditorjsTextField::make('content')
        ->minHeight(100);

    expect($field->getMinHeight())->toBe(100);
});

it('can set placeholder for editorjs field', function () {
    $field = EditorjsTextField::make('content')
        ->placeholder('Start writing...');

    expect($field->getPlaceholder())->toBe('Start writing...');
});
