@php
    $level = $level ?? 1;
    $text = $text ?? '';
    $config = $config ?? [];

    // Map header level to Tailwind classes
    $headerClasses = [
        1 => 'text-4xl font-bold mb-4 mt-6',
        2 => 'text-3xl font-bold mb-4 mt-6',
        3 => 'text-2xl font-bold mb-4 mt-6',
        4 => 'text-xl font-bold mb-4 mt-6',
        5 => 'text-lg font-bold mb-4 mt-6',
        6 => 'text-base font-bold mb-4 mt-6',
    ][$level] ?? 'text-2xl font-bold mb-4 mt-6';

    $tag = 'h' . $level;
@endphp

<{{ $tag }} class="{{ $headerClasses }} text-gray-900">{{ $text }}</{{ $tag }}>