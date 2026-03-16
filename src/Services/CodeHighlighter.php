<?php

namespace Athphane\FilamentEditorjs\Services;

use Spatie\ShikiPhp\Shiki;

class CodeHighlighter
{
    protected string $defaultTheme;

    protected bool $lineHighlighting;

    protected array $supportedLineModes;

    public function __construct()
    {
        $config = config('filament-editorjs.code', []);
        $this->defaultTheme = $config['default_theme'] ?? 'github-light';
        $this->lineHighlighting = $config['line_highlighting'] ?? true;
        $this->supportedLineModes = $config['supported_line_modes'] ?? ['highlight', 'add', 'delete', 'focus'];
    }

    public function highlight(
        string $code,
        string $language,
        ?string $theme = null,
        array $highlightLines = [],
        array $addLines = [],
        array $deleteLines = [],
        array $focusLines = []
    ): string {
        $theme ??= $this->defaultTheme;

        if ( ! $this->languageIsAvailable($language)) {
            $language = 'plaintext';
        }

        $cache_key = "filament-editorjs.code_highlight_{$language}_{$theme}_" . md5($code) . '_' . implode('_', $highlightLines) . '_' . implode('_', $addLines) . '_' . implode('_', $deleteLines) . '_' . implode('_', $focusLines);

        // cache the highlighted code to improve performance on repeated renders of the same code snippet
        return cache()->rememberForever($cache_key, function () use ($focusLines, $deleteLines, $addLines, $highlightLines, $language, $code) {
            return Shiki::highlight(
                code: $code,
                language: $language,
                theme: 'github-dark',
                highlightLines: $this->lineHighlighting ? $highlightLines : [],
                addLines: $this->lineHighlighting && in_array('add', $this->supportedLineModes) ? $addLines : [],
                deleteLines: $this->lineHighlighting && in_array('delete', $this->supportedLineModes) ? $deleteLines : [],
                focusLines: $this->lineHighlighting && in_array('focus', $this->supportedLineModes) ? $focusLines : [],
            );
        });
    }

    public function getAvailableLanguages(): array
    {
        $shiki = new Shiki();

        return $shiki->getAvailableLanguages();
    }

    public function getAvailableThemes(): array
    {
        $shiki = new Shiki();

        return $shiki->getAvailableThemes();
    }

    public function languageIsAvailable(string $language): bool
    {
        $shiki = new Shiki();

        return $shiki->languageIsAvailable($language);
    }

    public function themeIsAvailable(string $theme): bool
    {
        $shiki = new Shiki();

        return $shiki->themeIsAvailable($theme);
    }

    public function setDefaultTheme(string $theme): self
    {
        $this->defaultTheme = $theme;

        return $this;
    }

    public function getDefaultTheme(): string
    {
        return $this->defaultTheme;
    }
}
