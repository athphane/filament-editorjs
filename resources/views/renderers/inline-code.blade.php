@php
    $code = $code ?? '';
@endphp

<div class="my-2">
    <code
        class="px-1 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-mono text-sm border border-gray-200 dark:border-gray-700">{{ $code }}</code>
</div>