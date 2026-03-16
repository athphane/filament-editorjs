<div class="max-w-3xl mx-auto px-6">
    @php
        $code = $code ?? '';
        $language = $language ?? 'plaintext';
        $showLanguageLabel = $config['show_language_label'] ?? true;
    @endphp

    <div class="rounded-lg border border-gray-400 my-6">
        @if($showLanguageLabel && !empty($language) && $language !== 'plaintext')
            <div class="flex items-center justify-between rounded-t-lg bg-sky-400">
                <span class="ms-2 text-xs font-mono text-gray-500 dark:text-gray-400 uppercase">
                    {{ $language }}
                </span>
            </div>
        @endif

        <div class="code-block-wrapper">
            {!! $code !!}
        </div>
    </div>

</div>
