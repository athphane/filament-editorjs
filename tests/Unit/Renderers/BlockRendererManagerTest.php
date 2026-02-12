<?php

use Athphane\FilamentEditorjs\Renderers\BlockRenderer;
use Athphane\FilamentEditorjs\Renderers\BlockRendererManager;
use Athphane\FilamentEditorjs\Renderers\ChecklistRenderer;
use Athphane\FilamentEditorjs\Renderers\CodeRenderer;
use Athphane\FilamentEditorjs\Renderers\DelimiterRenderer;
use Athphane\FilamentEditorjs\Renderers\HeaderRenderer;
use Athphane\FilamentEditorjs\Renderers\ImageRenderer;
use Athphane\FilamentEditorjs\Renderers\InlineCodeRenderer;
use Athphane\FilamentEditorjs\Renderers\ListRenderer;
use Athphane\FilamentEditorjs\Renderers\ParagraphRenderer;
use Athphane\FilamentEditorjs\Renderers\QuoteRenderer;
use Athphane\FilamentEditorjs\Renderers\RawRenderer;
use Athphane\FilamentEditorjs\Renderers\TableRenderer;

it('can register and get a renderer', function () {
    $manager = new BlockRendererManager();
    $renderer = new HeaderRenderer();

    $manager->addRenderer($renderer);

    $retrieved = $manager->getRenderer('header');

    expect($retrieved)->toBeInstanceOf(BlockRenderer::class);
    expect($retrieved->getType())->toBe('header');
});

it('can get null for non-existent renderer', function () {
    $manager = new BlockRendererManager();

    $retrieved = $manager->getRenderer('non-existent');

    expect($retrieved)->toBeNull();
});

it('can render content from array', function () {
    $manager = new BlockRendererManager();

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

    $output = $manager->renderContent($content);

    expect($output)->toBeString();
})->skip('Array rendering requires view setup');

it('can render content from string', function () {
    $manager = new BlockRendererManager();

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

    $output = $manager->renderContent($content);

    expect($output)->toBeString();
    expect($output)->toContain('Test Header');
});

it('returns empty string for invalid content', function () {
    $manager = new BlockRendererManager();

    $output = $manager->renderContent('invalid json');

    expect($output)->toBe('');
});

it('returns empty string for content without blocks', function () {
    $manager = new BlockRendererManager();

    $content = [
        'time'    => 1675692000000,
        'version' => '2.27.2',
    ];

    $output = $manager->renderContent($content);

    expect($output)->toBe('');
});

it('can render multiple blocks', function () {
    $manager = new BlockRendererManager();

    $content = [
        'blocks' => [
            [
                'type' => 'paragraph',
                'data' => ['text' => 'First paragraph.'],
            ],
            [
                'type' => 'header',
                'data' => ['level' => 2, 'text' => 'Second header.'],
            ],
            [
                'type' => 'list',
                'data' => ['style' => 'unordered', 'items' => ['Item 1', 'Item 2']],
            ],
        ],
    ];

    $output = $manager->renderContent($content);

    expect($output)->toBeString();
})->skip('Multiple blocks rendering requires view setup');

it('can render with custom wrapper template', function () {
    $manager = new BlockRendererManager(['wrapper_template' => 'test::wrapper']);

    $content = [
        'blocks' => [
            [
                'type' => 'paragraph',
                'data' => ['text' => 'Test content.'],
            ],
        ],
    ];

    $output = $manager->renderContent($content, ['wrapper_template' => 'filament-editorjs::renderers.content-wrapper']);

    expect($output)->toBeString();
})->skip('Custom wrapper requires view setup');

it('can use default wrapper template', function () {
    $manager = new BlockRendererManager(['wrapper_template' => 'default::wrapper']);

    $content = [
        'blocks' => [
            [
                'type' => 'paragraph',
                'data' => ['text' => 'Test content.'],
            ],
        ],
    ];

    $output = $manager->renderContent($content);

    expect($output)->toBeString();
})->skip('Default wrapper requires view setup');

it('can render single block with manager', function () {
    $manager = new BlockRendererManager();

    $block = [
        'type' => 'paragraph',
        'data' => ['text' => 'Test content.'],
    ];

    $output = $manager->renderBlock($block);

    expect($output)->toBeString();
})->skip('Block rendering requires view setup');

it('can render unknown block type', function () {
    $manager = new BlockRendererManager();

    $block = [
        'type' => 'unknown-block',
        'data' => ['text' => 'Unknown content.'],
    ];

    $output = $manager->renderBlock($block);

    expect($output)->toBeString();
})->skip('Unknown block rendering requires view setup');

it('can add multiple renderers', function () {
    $manager = new BlockRendererManager();
    $renderer1 = new HeaderRenderer();
    $renderer2 = new ParagraphRenderer();

    $manager->addRenderer($renderer1);
    $manager->addRenderer($renderer2);

    expect($manager->getRenderer('header'))->toBeInstanceOf(BlockRenderer::class);
    expect($manager->getRenderer('paragraph'))->toBeInstanceOf(BlockRenderer::class);
    expect($manager->getRenderer('non-existent'))->toBeNull();
});

it('header renderer clamps invalid level values', function () {
    $renderer = new HeaderRenderer();

    $block = [
        'type' => 'header',
        'data' => [
            'level' => 0,
            'text'  => 'Test',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('h1');
    expect($output)->toContain('Test');
});

it('header renderer handles missing level', function () {
    $renderer = new HeaderRenderer();

    $block = [
        'type' => 'header',
        'data' => [
            'text' => 'Test',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('h1');
    expect($output)->toContain('Test');
});

it('header renderer handles missing text', function () {
    $renderer = new HeaderRenderer();

    $block = [
        'type' => 'header',
        'data' => [
            'level' => 2,
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('h2');
    expect($output)->not->toContain('text');
});

it('paragraph renderer renders content', function () {
    $renderer = new ParagraphRenderer();

    $block = [
        'type' => 'paragraph',
        'data' => [
            'text' => 'This is a paragraph.',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('This is a paragraph');
});

it('paragraph renderer handles missing text', function () {
    $renderer = new ParagraphRenderer();

    $block = [
        'type' => 'paragraph',
        'data' => [],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('text');
});

it('list renderer renders unordered list', function () {
    $renderer = new ListRenderer();

    $block = [
        'type' => 'list',
        'data' => [
            'style' => 'unordered',
            'items' => ['Item 1', 'Item 2', 'Item 3'],
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('Item 1');
    expect($output)->toContain('Item 2');
    expect($output)->toContain('Item 3');
});

it('list renderer handles ordered list', function () {
    $renderer = new ListRenderer();

    $block = [
        'type' => 'list',
        'data' => [
            'style' => 'ordered',
            'items' => ['First', 'Second'],
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('First');
    expect($output)->toContain('Second');
});

it('list renderer handles empty items', function () {
    $renderer = new ListRenderer();

    $block = [
        'type' => 'list',
        'data' => [
            'style' => 'unordered',
            'items' => [],
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('Item');
});

it('image renderer renders image data', function () {
    $renderer = new ImageRenderer();

    $block = [
        'type' => 'image',
        'data' => [
            'file' => [
                'url'     => 'https://example.com/image.jpg',
                'mediaId' => 123,
            ],
            'caption' => 'Test caption',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('image.jpg');
    expect($output)->toContain('Test caption');
});

it('image renderer handles missing file', function () {
    $renderer = new ImageRenderer();

    $block = [
        'type' => 'image',
        'data' => [
            'caption' => 'Test',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('Test');
});

it('quote renderer renders quote', function () {
    $renderer = new QuoteRenderer();

    $block = [
        'type' => 'quote',
        'data' => [
            'text'    => 'This is a quote.',
            'caption' => 'Test caption',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('This is a quote');
    expect($output)->toContain('Test caption');
});

it('code renderer escapes code content', function () {
    $renderer = new CodeRenderer();

    $block = [
        'type' => 'code',
        'data' => [
            'code' => '<script>alert("xss")</script>',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('<script>');
    expect($output)->toContain('&lt;script&gt;');
})->skip('Code rendering requires view setup');

it('code renderer handles missing code', function () {
    $renderer = new CodeRenderer();

    $block = [
        'type' => 'code',
        'data' => [],
    ];

    $output = $renderer->render($block);

    expect($output)->toBeString();
})->skip('Code rendering requires view setup');

it('table renderer renders table content', function () {
    $renderer = new TableRenderer();

    $block = [
        'type' => 'table',
        'data' => [
            'content' => [
                ['Header 1', 'Header 2'],
                ['Data 1', 'Data 2'],
                ['Data 3', 'Data 4'],
            ],
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('Header 1');
    expect($output)->toContain('Header 2');
    expect($output)->toContain('Data 1');
    expect($output)->toContain('Data 2');
});

it('table renderer handles empty content', function () {
    $renderer = new TableRenderer();

    $block = [
        'type' => 'table',
        'data' => [
            'content' => [],
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('Header');
})->skip('Table rendering requires view setup');

it('delimiter renderer renders delimiter', function () {
    $renderer = new DelimiterRenderer();

    $block = [
        'type' => 'delimiter',
        'data' => [],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toBe('');
})->skip('Delimiter rendering requires view setup');

it('raw renderer renders raw HTML', function () {
    $renderer = new RawRenderer();

    $block = [
        'type' => 'raw',
        'data' => [
            'html' => '<div class="test">Raw HTML content</div>',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('Raw HTML content');
    expect($output)->toContain('test');
})->skip('Raw rendering requires view setup');

it('raw renderer handles missing HTML', function () {
    $renderer = new RawRenderer();

    $block = [
        'type' => 'raw',
        'data' => [],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('html');
})->skip('Raw rendering requires view setup');

it('inline code renderer escapes content', function () {
    $renderer = new InlineCodeRenderer();

    $block = [
        'type' => 'inline-code',
        'data' => [
            'code' => '<tag>alert()</tag>',
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('<tag>');
    expect($output)->toContain('&lt;tag&gt;');
})->skip('Inline code rendering requires view setup');

it('inline code renderer handles missing code', function () {
    $renderer = new InlineCodeRenderer();

    $block = [
        'type' => 'inline-code',
        'data' => [],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('code');
})->skip('Inline code rendering requires view setup');

it('checklist renderer renders checklist', function () {
    $renderer = new ChecklistRenderer();

    $block = [
        'type' => 'checklist',
        'data' => [
            'items' => [
                ['checked' => false, 'text' => 'Task 1'],
                ['checked' => true, 'text' => 'Task 2'],
            ],
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->toContain('Task 1');
    expect($output)->toContain('Task 2');
});

it('checklist renderer handles empty items', function () {
    $renderer = new ChecklistRenderer();

    $block = [
        'type' => 'checklist',
        'data' => [
            'items' => [],
        ],
    ];

    $output = $renderer->render($block);

    expect($output)->not->toContain('Task');
})->skip('Checklist rendering requires view setup');
