<div class="max-w-3xl mx-auto px-6">
    @php
        $level = $level ?? 1;
        $text = $text ?? '';

        $headerClasses = [
            1 => 'text-4xl font-extrabold mb-0 mt-10',
            2 => 'text-3xl font-bold mb-0 mt-8',
            3 => 'text-2xl font-bold mb-0 mt-6',
            4 => 'text-xl font-bold mb-0 mt-4',
            5 => 'text-lg font-bold mb-0 mt-4',
            6 => 'text-base font-bold mb-0 mt-4',
        ][$level] ?? 'text-2xl font-bold mb-4 mt-6';

        $tag = 'h' . $level;
    @endphp

    <{{ $tag }}
    @class([
    $headerClasses,
    'text-zinc-800',
    'my-[1.25rem] leading-[1.8]'
])>
    {!! $text !!}
</{{ $tag }}>
</div>
