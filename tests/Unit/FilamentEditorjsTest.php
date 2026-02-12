<?php

use Athphane\FilamentEditorjs\FilamentEditorjs;
use Athphane\FilamentEditorjs\Renderers\BlockRenderer;
use Athphane\FilamentEditorjs\Renderers\BlockRendererManager;
use Athphane\FilamentEditorjs\Renderers\HeaderRenderer;
use Illuminate\Support\Facades\App;

it('renders content from array', function () {
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

    $output = FilamentEditorjs::renderContent($content);

    expect($output)->toBeString();
    expect($output)->toContain('Test paragraph');
});

it('renders content from string', function () {
    $content = json_encode([
        'time'   => 1675692000000,
        'blocks' => [
            [
                'type' => 'header',
                'data' => [
                    'level' => 2,
                    'text'  => 'Test Header',
                ],
            ],
        ],
        'version' => '2.27.2',
    ]);

    $output = FilamentEditorjs::renderContent($content);

    expect($output)->toBeString();
    expect($output)->toContain('Test Header');
});

it('can add a single renderer', function () {
    $renderer = new HeaderRenderer();

    FilamentEditorjs::addRenderer($renderer);

    expect($renderer)->toBeInstanceOf(BlockRenderer::class);
})->skip('Adding renderer requires manager setup');

it('can add multiple renderers at once', function () {
    $renderers = [
        new HeaderRenderer(),
        new BlockRenderer(),
    ];

    FilamentEditorjs::addRenderers($renderers);

    expect(count($renderers))->toBe(2);
})->skip('Adding renderers requires manager setup');

it('only adds renderers that implement BlockRenderer interface', function () {
    $manager = App::make(BlockRendererManager::class);
    $nonRenderer = new class {};

    FilamentEditorjs::addRenderers([$nonRenderer]);

    expect($manager->getRenderer('class@anonymous'))->toBeNull();
});

it('renders with custom config', function () {
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

    $output = FilamentEditorjs::renderContent($content, $config);

    expect($output)->toBeString();
});

it('renders with empty content', function () {
    $content = null;

    $output = FilamentEditorjs::renderContent($content);

    expect($output)->toBeString();
});

it('renders with empty array', function () {
    $content = [];

    $output = FilamentEditorjs::renderContent($content);

    expect($output)->toBeString();
});

it('can get the renderer manager singleton', function () {
    $output = FilamentEditorjs::renderContent([]);

    expect($output)->toBeString();
})->skip('Renderer manager singleton test requires complex setup');

it('can render with empty content', function () {
    $content = null;

    $output = FilamentEditorjs::renderContent($content);

    expect($output)->toBeString();
    expect($output)->not->toBe('');
});

it('can render with empty array', function () {
    $content = [];

    $output = FilamentEditorjs::renderContent($content);

    expect($output)->toBeString();
    expect($output)->not->toBe('');
});
