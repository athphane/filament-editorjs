<?php

use Athphane\FilamentEditorjs\Renderers\CodeRenderer;

beforeEach(function () {
    $this->renderer = new CodeRenderer();
});

it('renders code block with language', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => '<?php echo "Hello World"; ?>',
            'languageCode' => 'php',
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('shiki');
});

it('renders code block with custom theme', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => 'const x = 1;',
            'languageCode' => 'javascript',
        ],
    ];

    $config = ['theme' => 'github-dark'];
    $output = $this->renderer->render($block, $config);

    expect($output)->toContain('shiki');
});

it('renders code block with line highlighting', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => "line 1\nline 2\nline 3",
            'languageCode' => 'plaintext',
            'highlightLines' => [1, 3],
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('highlighted');
});

it('renders code block with added lines', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => "line 1\nline 2\nline 3",
            'languageCode' => 'plaintext',
            'addLines' => [2],
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('added');
});

it('renders code block with deleted lines', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => "line 1\nline 2\nline 3",
            'languageCode' => 'plaintext',
            'deleteLines' => [2],
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('deleted');
});

it('renders code block with focused lines', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => "line 1\nline 2\nline 3",
            'languageCode' => 'plaintext',
            'focusLines' => [2],
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('focused');
});

it('handles missing languageCode with fallback', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => 'some code',
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('pre');
    expect($output)->toContain('code');
});

it('handles invalid languageCode gracefully', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => 'some code',
            'languageCode' => 'invalid-language-xyz',
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('pre');
});

it('handles empty code', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => '',
            'languageCode' => 'plaintext',
        ],
    ];

    $output = $this->renderer->render($block);

    expect($output)->toContain('pre');
});

it('shows language label when enabled', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => 'const x = 1;',
            'languageCode' => 'javascript',
        ],
    ];

    $config = ['show_language_label' => true];
    $output = $this->renderer->render($block, $config);

    expect($output)->toContain('javascript');
});

it('hides language label when disabled', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => 'const x = 1;',
            'languageCode' => 'javascript',
        ],
    ];

    $config = ['show_language_label' => false];
    $output = $this->renderer->render($block, $config);

    expect($output)->not->toContain('javascript');
});

it('hides language label for plaintext', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => 'some plain text',
            'languageCode' => 'plaintext',
        ],
    ];

    $config = ['show_language_label' => true];
    $output = $this->renderer->render($block, $config);

    expect($output)->not->toContain('plaintext');
});

it('returns correct type', function () {
    expect($this->renderer->getType())->toBe('code');
});

it('calculates word count correctly', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => 'function hello() { return "world"; }',
        ],
    ];

    $count = $this->renderer->getWordCount($block);

    expect($count)->toBe(3);
});

it('handles word count with empty code', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => '',
        ],
    ];

    $count = $this->renderer->getWordCount($block);

    expect($count)->toBe(0);
});

it('handles word count with multiline code', function () {
    $block = [
        'type' => 'code',
        'data' => [
            'code' => "line one\nline two\nline three",
        ],
    ];

    $count = $this->renderer->getWordCount($block);

    expect($count)->toBe(6);
});
