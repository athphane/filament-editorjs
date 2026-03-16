<?php

namespace Athphane\FilamentEditorjs\Renderers;

use Athphane\FilamentEditorjs\Services\CodeHighlighter;

class CodeRenderer extends BlockRenderer
{
    protected CodeHighlighter $highlighter;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->highlighter = app(CodeHighlighter::class);
    }

    public function render(array $block, array $config = []): string
    {
        $data = $block['data'] ?? [];
        $code = $data['code'] ?? $data['message'] ?? $data['content'] ?? '';
        $language = $data['languageCode'] ?? 'plaintext';

        $theme = $config['theme'] ?? $this->get('theme');
        $highlightLines = $data['highlightLines'] ?? [];
        $addLines = $data['addLines'] ?? [];
        $deleteLines = $data['deleteLines'] ?? [];
        $focusLines = $data['focusLines'] ?? [];

        try {
            $highlightedCode = $this->highlighter->highlight(
                code: $code,
                language: $language,
                theme: $theme,
                highlightLines: $highlightLines,
                addLines: $addLines,
                deleteLines: $deleteLines,
                focusLines: $focusLines,
            );
        } catch (\Exception $e) {
            $highlightedCode = $this->fallbackHighlight($code);
        }

        return view('filament-editorjs::renderers.code', [
            'code'         => $highlightedCode,
            'language'     => $language,
            'config'       => array_merge($this->config, $config),
        ])->render();
    }

    protected function fallbackHighlight(string $code): string
    {
        $escapedCode = htmlspecialchars($code, ENT_QUOTES, 'UTF-8');

        return "<pre><code>{$escapedCode}</code></pre>";
    }

    public function getType(): string
    {
        return 'code';
    }

    public function getWordCount(array $block): int
    {
        $text = data_get($block, 'data.code', '');
        return str_word_count(strip_tags($text));
    }
}
