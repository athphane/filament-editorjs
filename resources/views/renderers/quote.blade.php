<div class="max-w-3xl mx-auto px-6">
    @php
        $alignmentClasses = [
            'left' => 'text-left border-l-4',
            'center' => 'text-center border-y-2 py-4',
            'right' => 'text-right border-r-4',
        ][$alignment] ?? 'text-left border-l-4';
    @endphp

    <blockquote>
        <p class="{{ $alignmentClasses }}">
            {!! $text !!}
        </p>

        @if($caption)
            <cite class="text-sm font-normal text-gray-500 block mt-3">
                — {{ $caption }}
            </cite>
        @endif
    </blockquote>
</div>
