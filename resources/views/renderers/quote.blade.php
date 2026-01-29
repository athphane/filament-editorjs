@php
    $content = $content ?? '';
    $caption = $caption ?? '';
    $alignment = $alignment ?? 'left';

    $alignmentClasses = [
        'left' => 'text-left border-l-4',
        'center' => 'text-center border-y-2 py-4',
        'right' => 'text-right border-r-4',
    ][$alignment] ?? 'text-left border-l-4';
@endphp

<blockquote
    class="my-8 pl-4 border-gray-300 dark:border-gray-700 italic text-xl text-gray-700 dark:text-gray-300 {{ $alignmentClasses }}">
    <p class="mb-2">
        {!! $content !!}
    </p>

    @if($caption)
        <cite class="text-sm font-normal text-gray-500 block">
            — {{ $caption }}
        </cite>
    @endif
</blockquote>