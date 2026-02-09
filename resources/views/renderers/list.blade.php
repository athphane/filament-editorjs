<div class="max-w-3xl mx-auto px-6">
    @php
        $tag = ($style === 'ordered') ? 'ol' : 'ul';
        $listClasses = $tag === 'ol' ? 'list-decimal ml-6 mt-3' : 'list-disc ml-6 mt-3';
    @endphp

<{{ $tag }} @class([$listClasses])>
    @foreach($items as $item)
        <li class="mb-2">{!! $item !!}</li>
    @endforeach
</{{ $tag }}>
</div>
