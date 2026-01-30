@php
    $stretched = $stretched ?? false;
    $withBorder = $withBorder ?? false;
    $withBackground = $withBackground ?? false;
@endphp

@if(! $stretched)
    <div class="max-w-3xl mx-auto px-6">
@endif
        <figure class="mt-8">
            <img src="{{ $file['url'] }}" alt="{{$caption}}"
                @class([
                   'block mx-auto',
                   'rounded-lg' => (!$stretched) || $withBorder,
                   'border border-gray-200 shadow-sm' => $withBorder,
                   'bg-gray-100 dark:bg-gray-900 p-4' => $withBackground,
               ])
            >
            <figcaption class="text-xs pt-3 text-center text-zinc-400">{{$caption}}</figcaption>
        </figure>
@if(! $stretched)
</div>
@endif
