@php
    $blocks = $blocks ?? [];
    $config = $config ?? [];

    $containerClasses = $config['container_classes'] ?? 'prose prose-gray max-w-none';
@endphp

<div class="{{ $containerClasses }}">
    @foreach($blocks as $block)
        {!! $block !!}
    @endforeach
</div>
