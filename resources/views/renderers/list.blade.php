@php
    $items = $items ?? [];
    $style = $style ?? 'unordered';

    $tag = ($style === 'ordered') ? 'ol' : 'ul';
    $listClasses = $tag === 'ol' ? 'list-decimal ml-6' : 'list-disc ml-6';
@endphp

<{{ $tag }} class="{{ $listClasses }} mb-6 space-y-2 text-gray-800 dark:text-gray-200">
    @foreach($items as $item)
        <li>{!! $item !!}</li>
    @endforeach
</{{ $tag }}>