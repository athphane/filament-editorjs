<div class="max-w-3xl mx-auto px-6">
    @php
        $code = $code ?? '';
        $language = $language ?? 'plaintext';
        $showLanguageLabel = $config['show_language_label'] ?? true;
    @endphp

    @if($showLanguageLabel && !empty($language) && $language !== 'plaintext')
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-mono text-gray-500 dark:text-gray-400 uppercase">
                {{ $language }}
            </span>
        </div>
    @endif

    <div class="code-block-wrapper my-6">
        {!! $code !!}
    </div>

</div>
