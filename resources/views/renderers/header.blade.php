<div class="max-w-3xl mx-auto px-6">
    @php
        $level = $level ?? 1;
        $text = $text ?? '';

        $headerClasses = [
            1 => 'text-4xl font-extrabold',
            2 => 'text-3xl font-bold',
            3 => 'text-2xl font-bold',
            4 => 'text-xl font-bold',
            5 => 'text-lg font-bold',
            6 => 'text-base font-bold',
        ][$level] ?? 'text-2xl font-bold mb-4 mt-6';

        $tag = 'h' . $level;
    @endphp

<{{ $tag }}
    @class([
    $headerClasses,
    'text-zinc-800',
    'pt-4'
])>
    {!! $text !!}
</{{ $tag }}>
</div>
