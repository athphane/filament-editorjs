@php
    $url = $url ?? '';
    $caption = $caption ?? '';
    $withBorder = $withBorder ?? false;
    $withBackground = $withBackground ?? false;
    $stretched = $stretched ?? false;
    $config = $config ?? [];

    $imageClasses = collect([
        'block mx-auto',
        $withBorder ? 'border border-gray-200' : '',
        $withBackground ? 'bg-gray-100 p-4' : '',
        $stretched ? 'w-full max-w-none' : 'max-w-full',
    ])->filter()->join(' ');
@endphp

<div class="my-6">
    @if($url)
        <img src="{{ $url }}" alt="{{ $caption ?: 'EditorJS Image' }}" class="{{ $imageClasses }}">
    @endif

    @if($caption)
        <p class="text-center text-sm text-gray-500 mt-2">{{ $caption }}</p>
    @endif
</div>