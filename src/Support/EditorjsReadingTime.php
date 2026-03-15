<?php

namespace Athphane\FilamentEditorjs\Support;

class EditorjsReadingTime
{
    /**
     * Calculate reading time string from EditorJS content.
     */
    public static function calculate(array|string|null $content, array $config = []): string
    {
        $wordsPerMinute = (int) ($config['words_per_minute']
            ?? config('filament-editorjs.reading_time.words_per_minute', 225));

        if ($wordsPerMinute < 1) {
            $wordsPerMinute = 225;
        }

        $totalWords = self::countWords($content);
        $minutes = (int) ceil($totalWords / $wordsPerMinute);

        if ($minutes < 1) {
            return '1 min read';
        }

        return $minutes . ' min read';
    }

    /**
     * Count words in EditorJS content.
     */
    public static function countWords(array|string|null $content): int
    {
        $data = is_string($content) ? json_decode($content, true) : $content;

        if ( ! is_array($data)) {
            return 0;
        }

        $blocks = $data['blocks'] ?? [];

        if ( ! is_array($blocks)) {
            return 0;
        }

        $manager = app('filament-editorjs-renderer');
        $totalWords = 0;

        foreach ($blocks as $block) {
            $renderer = $manager->getRenderer($block['type'] ?? '');
            if ($renderer) {
                $totalWords += $renderer->getWordCount($block);
            }
        }

        return $totalWords;
    }
}
