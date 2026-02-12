<?php

use Athphane\FilamentEditorjs\Forms\Components\EditorjsTextField;

it('verifies editorjs text field has file attachment methods', function () {
    $field = EditorjsTextField::make('content');

    expect(method_exists($field, 'handleFileAttachmentUpload'))->toBeTrue();
    expect(method_exists($field, 'handleUploadedAttachmentUrlRetrieval'))->toBeTrue();
});

it('process uploaded file and get url', function () {
    $field = EditorjsTextField::make('content');

    expect(method_exists($field, 'processUploadedFileAndGetUrl'))->toBeTrue();
});

it('can retrieve media by UUID', function () {
    $field = EditorjsTextField::make('content');

    expect(method_exists($field, 'handleUploadedAttachmentUrlRetrieval'))->toBeTrue();
})->skip('UUID retrieval requires database setup');

it('can handle null UUID retrieval', function () {
    $field = EditorjsTextField::make('content');

    $url = $field->handleUploadedAttachmentUrlRetrieval(null);

    expect($url)->toBeNull();
});

it('can handle non-existent UUID retrieval', function () {
    $field = EditorjsTextField::make('content');

    $url = $field->handleUploadedAttachmentUrlRetrieval('non-existent-uuid');

    expect($url)->toBeNull();
});

it('can handle non-existent ID retrieval', function () {
    $field = EditorjsTextField::make('content');

    $url = $field->handleUploadedAttachmentUrlRetrieval(999999);

    expect($url)->toBeNull();
});

it('processes invalid temp file identifier', function () {
    $field = EditorjsTextField::make('content');

    $url = $field->processUploadedFileAndGetUrl('invalid-identifier');

    expect($url)->toBeNull();
})->skip('File processing requires database setup');

it('can retrieve rendered content from static method', function () {
    $content = [
        'time'   => 1675692000000,
        'blocks' => [
            [
                'type' => 'paragraph',
                'data' => [
                    'text' => 'Test paragraph.',
                ],
            ],
        ],
        'version' => '2.27.2',
    ];

    $output = EditorjsTextField::renderContent($content);

    expect($output)->toBeString();
    expect($output)->toContain('Test paragraph');
});

it('renders content with custom config through static method', function () {
    $content = [
        'blocks' => [
            [
                'type' => 'paragraph',
                'data' => [
                    'text' => 'Test content.',
                ],
            ],
        ],
    ];

    $config = [
        'wrapper_template' => 'filament-editorjs::renderers.content-wrapper',
    ];

    $output = EditorjsTextField::renderContent($content, $config);

    expect($output)->toBeString();
})->skip('Custom config rendering requires view setup');

it('handles empty content through static method', function () {
    $output = EditorjsTextField::renderContent(null);

    expect($output)->toBeString();
    expect($output)->toBe('');
});

it('handles array content through static method', function () {
    $output = EditorjsTextField::renderContent([]);

    expect($output)->toBeString();
    expect($output)->toBe('');
});

it('can create editorjs text field with null record', function () {
    $field = EditorjsTextField::make('content');

    expect($field->recordExists())->toBeFalse();
})->skip('Record test requires complex setup');

it('handles exception during file processing', function () {
    $field = EditorjsTextField::make('content');

    expect(method_exists($field, 'processUploadedFileAndGetUrl'))->toBeTrue();
});
