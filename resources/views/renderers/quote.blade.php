<div class="max-w-3xl mx-auto px-6">
    @php
        $alignmentClasses = [
            'left' => 'text-left pl-6 border-l-4',
            'right' => 'text-right pr-6 border-r-4',
        ][$alignment] ?? 'text-left pl-6 border-l-4';
    @endphp

    <blockquote>
        <p @class([
            $alignmentClasses,
            'mt-5'
          ])
        >
            {!! $text !!}
        </p>

        @if($caption)
            <cite class="text-sm font-normal text-gray-500 block mt-3">
                — {{ $caption }}
            </cite>
        @endif
    </blockquote>
</div>
