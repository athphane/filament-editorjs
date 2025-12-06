@php
    $items = $items ?? [];
    $style = $style ?? 'unordered'; // 'ordered' or 'unordered'
    $config = $config ?? [];

    $listTag = $style === 'ordered' ? 'ol' : 'ul';
    $listClasses = $style === 'ordered'
        ? 'list-decimal list-inside my-4 pl-4 space-y-2'
        : 'list-disc list-inside my-4 pl-4 space-y-2';
@endphp

<{{ $listTag }} class="{{ $listClasses }}">
    @foreach($items as $item)
        <li class="text-gray-700">{{ $item }}</li>
    @endforeach
</{{ $listTag }}>