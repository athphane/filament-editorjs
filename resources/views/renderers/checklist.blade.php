@php
    $items = $items ?? [];
    $config = $config ?? [];
@endphp

<ul class="my-4 space-y-2 list-none p-0">
    @foreach($items as $item)
        <li class="flex items-start">
            <input
                type="checkbox"
                @checked($item['checked'])
                class="mt-1 mr-2 h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                disabled
            >
            <span class="text-gray-700 {{ $item['checked'] ? 'line-through text-gray-500' : '' }}">
                {{ $item['content'] }}
            </span>
        </li>
    @endforeach
</ul>