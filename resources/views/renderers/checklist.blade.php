@php
    $items = $items ?? [];
@endphp

<ul class="my-6 space-y-2">
    @foreach($items as $item)
        <li class="flex items-start">
            <div class="flex-shrink-0 mt-1">
                @if($item['checked'] ?? false)
                    <span class="text-green-500">✓</span>
                @else
                    <span class="inline-block w-4 h-4 border border-gray-300 dark:border-gray-600 rounded"></span>
                @endif
            </div>
            <div
                class="ml-3 text-gray-700 dark:text-gray-300 {!! ($item['checked'] ?? false) ? 'line-through text-gray-400' : '' !!}">
                {!! $item['content'] !!}
            </div>
        </li>
    @endforeach
</ul>