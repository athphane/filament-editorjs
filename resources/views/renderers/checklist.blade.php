<div class="max-w-3xl mx-auto px-6">
    @php
        $items = $items ?? [];
    @endphp

    <ul class="list-disc ml-6 pt-[1rem]">
        @foreach($items as $item)
            <li class="mb-2">
                @if($item['checked'])
                    <s>{!! $item['text'] !!}</s>
                @else
                    {!! $item['text'] !!}
                @endif
            </li>
        @endforeach
    </ul>
</div>
