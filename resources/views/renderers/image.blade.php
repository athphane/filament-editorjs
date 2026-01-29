@php
    $url = $url ?? '';
    $caption = $caption ?? '';
    $withBorder = $withBorder ?? false;
    $withBackground = $withBackground ?? false;
    $stretched = $stretched ?? false;

    $imageClasses = collect([
        'block mx-auto rounded-lg',
        $withBorder ? 'border border-gray-200 dark:border-gray-800' : '',
        $withBackground ? 'bg-gray-100 dark:bg-gray-900 p-4' : '',
        $stretched ? 'w-full' : 'max-w-full',
    ])->filter()->join(' ');
@endphp

<figure class="my-10">
    @if($url)
        <img src="{{ $url }}" alt="{{ $caption ?: 'EditorJS Image' }}" class="{{ $imageClasses }}">
    @endif

    @if($caption)
        <figcaption class="text-center text-sm text-gray-500 mt-3 italic">
            {{ $caption }}
        </figcaption>
    @endif
</figure>